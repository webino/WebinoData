<?php

namespace WebinoData\DataPlugin;

use WebinoData\DataEvent;
use WebinoData\DataService;
use WebinoData\DataSelect\ArrayColumn;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Expression as SqlExpression;
use Zend\Db\Sql\Predicate\In as SqlIn;
use Zend\EventManager\EventManager;

/**
 * Class Relations
 */
class Relations
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function attach(EventManager $eventManager)
    {
        $eventManager->attach('data.exchange.pre', [$this, 'preExchange'], 500);
        $eventManager->attach('data.exchange.invalid', [$this, 'preExchange'], 500);
        $eventManager->attach('data.exchange.post', [$this, 'postExchange'], 500);
        $eventManager->attach('data.fetch.pre', [$this, 'preFetch'], 500);
        $eventManager->attach('data.fetch.post', [$this, 'postFetch'], 500);
    }

    public function preExchange(DataEvent $event)
    {
        $this->associateExchange($event);
    }

    public function postExchange(DataEvent $event)
    {
        $this->compositeExchange($event);
    }

    public function preFetch(DataEvent $event)
    {
        $service = $event->getService();
        $select  = $event->getSelect();
        $columns = $select->getColumns();

        foreach ($columns as $key => $column) {

            if ($service->hasOne($key)) {

                $options = $service->oneOptions($key);

                if ($this->relationsDisabled($options)) {
                    continue;
                }

                if (is_string($column) || $column instanceof ArrayColumn) {
                    $subSelect = $service->one($key)->configSelect((array) $column);
                    $select->subselect($key, $subSelect);
                }

                $select->addColumn($key, new SqlExpression('\'0\''));
                continue;
            }

            if (!$service->hasMany($key)) {
                continue;
            }

            $options = $service->manyOptions($key);

            if ($this->relationsDisabled($options)) {
                continue;
            }

            if (is_string($column) || $column instanceof ArrayColumn) {
                $subSelect = $service->many($key)->configSelect((array) $column);
                $select->subselect($key, $subSelect);
            }

            $select->addColumn($key, new SqlExpression('\'0\''));
        }
    }

    public function postFetch(DataEvent $event)
    {
        $this->associateFetch($event);
        $this->compositeFetch($event);
    }

    protected function associateExchange(DataEvent $event)
    {
        $service   = $event->getService();
        $data      = $event->getData();
        $validData = $event->getValidData();

        foreach ($data->getArrayCopy() as $key => $value) {
            if (!$service->hasOne($key)
                || !is_array($value)
            ) {
                continue;
            }

            $options = $service->oneOptions($key);
            if ($this->relationsDisabled($options)) {
                continue;
            }

            $subService = $service->one($key);
            $subService->exchangeArray($value);

            $idKey = $this->resolveSubKey($key . '_id', $options);
            $data[$idKey] = !empty($value['id']) ? $value['id'] : $subService->getLastInsertValue();
            $validData[$idKey] = $data[$idKey];
        }
    }

    protected function associateFetch(DataEvent $event)
    {
        $rows = $event->getRows();
        if (0 === $rows->count()) {
            return;
        }

        $service  = $event->getService();
        $select   = $event->getSelect();
        $columns  = $select->getColumns();
        $attached = [];

        foreach (array_keys($columns) as $key) {
            if (!$service->hasOne($key)) {
                continue;
            }

            $options = $service->oneOptions($key);

            if ($this->relationsDisabled($options)) {
                continue;
            }

            $attached[$key] = $options;

            $select->subselect($key)
                or $select->subselect($key, $service->one($key)->select());
        }

        if (empty($attached)) {
            return;
        }

        foreach ($attached as $key => $options) {
            $idKey  = $subKey = $this->resolveSubKey($key . '_id', $options);
            $subIds = [];

            foreach ($rows as &$row) {
                is_array($row[$key]) or $row[$key] = [];
                empty($row[$idKey])  or $subIds[$row[$idKey]] = $row[$idKey];
            }

            if (empty($subIds)) {
                continue;
            }

            $subSelect  = clone $select->subselect($key);
            $subService = $service->one($key);
            $tableName  = $subService->getTableName();

            $subSelect->where(new SqlIn($tableName . '.id', $subIds));

            $subItems = $subService->fetchWith($subSelect);

            foreach ($rows as &$row) {

                empty($row[$idKey]) || empty($subItems[$row[$idKey]])
                    or $row[$key] = $subItems[$row[$idKey]];
            }
        }
    }

    protected function compositeExchange(DataEvent $event)
    {
        $service   = $event->getService();
        $tableName = $service->getTableName();
        $data      = $event->getData();
        $mainId    = !empty($data['id']) ? $data['id'] : $service->getLastInsertValue();

        foreach ($data->getArrayCopy() as $key => $values) {
            if (!$service->hasMany($key)) {
                continue;
            }

            $options = $service->manyOptions($key);

            if ($this->relationsDisabled($options)) {
                continue;
            }

            $subService = $service->many($key);

            if (!isset($values)) {
                continue;
            }

            $manyToMany = array_key_exists('oneToMany', $options)
                        ? !$options['oneToMany']
                        : true;

            // delete association
            $this->assocDelete(
                $service,
                $subService,
                $mainId,
                $options,
                // TODO, for BC only (remove deprecated)
                $manyToMany ? (isset($options['keySuffix']) ? $options['keySuffix'] : 'id') : '_id',
                array_filter(array_column($values, 'id'))
            );

            $event->setAffectedRows($event->getAffectedRows() + 1);

            if (empty($values)) {
                continue;
            }

            foreach ($values as $value) {
                $valueIsNumeric = is_numeric($value);

                if (!$valueIsNumeric) {
                    $manyToMany or $value[$tableName . '_id'] = $mainId;

                    $subService->exchangeArray($value);
                }

                if ($manyToMany) {
                    $subId = $valueIsNumeric
                           ? $value
                           : (!empty($value['id']) ? $value['id'] : $subService->getLastInsertValue());

                    $this->assocInsert(
                        $service,
                        $subService,
                        $mainId,
                        $subId,
                        $options
                    );
                }
            }
        }
    }

    protected function compositeFetch(DataEvent $event)
    {
        $rows = $event->getRows();

        if (0 === $rows->count()) {
            return;
        }

        $service  = $event->getService();
        $select   = $event->getSelect();
        $columns  = $select->getColumns();
        $attached = [];

        foreach (array_keys($columns) as $key) {
            if (!$service->hasMany($key)) {
                continue;
            }

            $options = $service->manyOptions($key);

            if ($this->relationsDisabled($options)) {
                continue;
            }

            $attached[$key] = $options;

            $select->subselect($key)
                or $select->subselect($key, $service->many($key)->select());
        }

        if (empty($attached)) {
            return;
        }

        $mainIds   = array_keys($rows->getArrayCopy());
        $tableName = $service->getTableName();

        foreach ($attached as $key => $options) {

            $subSelect  = clone $select->subselect($key);
            $subService = $service->many($key);
            // TODO, for BC only (remove deprecated)
            $keySuffix  = '_id';

            // decide relation
            $subKey = $this->resolveSubKey($tableName, $options);
            if ($subService->hasMany($subKey)) {
                // bidirectional
                // TODO, for BC only (remove deprecated)
                $keySuffix = isset($options['keySuffix']) ? $options['keySuffix'] : 'id';
                $this->assocJoin($subSelect, $service, $subService, $options);
            }

            $mainKey = $tableName . $keySuffix;
            $subSelect->where(new SqlIn($mainKey, $mainIds));

            $limit = $subSelect->getLimit();
            $subSelect->reset('limit');

            $subItems = $subService->fetchWith($subSelect);

            foreach ($rows as &$row) {
                is_array($row[$key]) or $row[$key] = [];

                foreach ($subItems as $subItem) {

                    if ($subItem[$mainKey] !== $row['id']
                        || ($limit && $limit <= count($row[$key]))
                    ) {
                        continue;
                    }

                    if (!empty($subItem['id'])
                        && empty($row[$key][$subItem['id']])
                    ) {
                        $row[$key][$subItem['id']] = $subItem;
                    } else {
                        $row[$key][] = $subItem;
                    }
                }
            }
        }
    }

    protected function assocInsert(DataService $service, DataService $subService, $mainId, $subId, array $options)
    {
        $platform = $service->getPlatform();

        $qi = function($name) use ($platform) { return $platform->quoteIdentifier($name); };
        $qv = function($name) use ($platform) { return $platform->quoteValue($name); };

        $tableName      = $service->getTableName();
        $subTableName   = $subService->getTableName();
        $assocTableName = $this->resolveAssocTableName($tableName, $subTableName, $options);

        // TODO, for BC only (remove deprecated)
        $keySuffix = isset($options['keySuffix']) ? $options['keySuffix'] : 'id';

        $sql = 'INSERT IGNORE INTO ' . $qi($assocTableName)
             . ' (' . $qi($tableName . $keySuffix) . ', ' . $qi($subTableName . $keySuffix) . ')'
             . ' VALUES (' . $qv($mainId) . ', ' . $qv($subId) . ')';

        $this->adapter->query($sql)->execute();
    }

    protected function assocDelete(
        DataService $service,
        DataService $subService,
        $mainId,
        array $options,
        $idSuffix,
        array $idsExclude = []
    ) {
        $platform = $service->getPlatform();

        $qi = function($name) use ($platform) { return $platform->quoteIdentifier($name); };
        $qv = function($name) use ($platform) { return $platform->quoteValue($name); };

        $tableName      = $service->getTableName();
        $subTableName   = $subService->getTableName();
        $assocTableName = $this->resolveAssocTableName($tableName, $subTableName, $options);

        $sql = 'DELETE FROM ' . $qi($assocTableName)
             . ' WHERE ' . $qi($tableName . $idSuffix) . ' = ' . $qv($mainId);

        // exclude ids to update
        empty($idsExclude)
            or $sql.= ' AND ' . $qi($subTableName . $idSuffix) . ' NOT IN (' . join(',', $idsExclude) . ')';

        $this->adapter->query($sql)->execute();
    }

    protected function assocJoin($select, DataService $service, DataService $subService, array $options)
    {
        // todo DRY
        $tableName      = $service->getTableName();
        $subTableName   = $subService->getTableName();
        $assocTableName = $this->resolveAssocTableName($tableName, $subTableName, $options);

        // TODO, for BC only (remove deprecated)
        $keySuffix = isset($options['keySuffix']) ? $options['keySuffix'] : 'id';

        $select->join($assocTableName, $subTableName . '.id=' . $assocTableName . '.' . $subTableName . $keySuffix);
    }

    protected function resolveSubKey($tableName, array $options)
    {
        return !empty($options['key']) ? $options['key'] : $tableName;
    }

    protected function resolveAssocTableName($tableName, $subTableName, array $options)
    {
        return !empty($options['tableName']) ? $options['tableName'] : $tableName . '_' . $subTableName;
    }

    /**
     * Return true when relations are disabled by options
     *
     * @param array $options
     * @return bool
     */
    protected function relationsDisabled(array $options)
    {
        return array_key_exists('relations', $options) && false === $options['relations'];
    }
}
