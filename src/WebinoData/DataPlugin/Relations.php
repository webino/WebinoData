<?php

namespace WebinoData\DataPlugin;

use WebinoData\DataEvent;
use WebinoData\DataService;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Expression as SqlExpression;
use Zend\Db\Sql\Predicate\In as SqlIn;
use Zend\EventManager\EventManager;

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
        $eventManager->attach('data.exchange.pre', array($this, 'preExchange'));
        $eventManager->attach('data.exchange.post', array($this, 'postExchange'));
        $eventManager->attach('data.fetch.pre', array($this, 'preFetch'));
        $eventManager->attach('data.fetch.post', array($this, 'postFetch'));
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

                if (is_string($column) || is_array($column)) {
                    $subSelect = $service->one($key)->configSelect($column);
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

            if (is_string($column) || is_array($column)) {
                $subSelect = $service->many($key)->configSelect($column);
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

            $validData[$key . '_id'] = !empty($value['id'])
                                       ? $value['id']
                                       : $subService->getLastInsertValue();
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
        $attached = array();

        foreach (array_keys($columns) as $key) {
            if (!$service->hasOne($key)) {
                continue;
            }

            $options = $service->oneOptions($key);

            if ($this->relationsDisabled($options)) {
                continue;
            }

            $attached[$key] = $options;

            $select->subselect($key) or
                $select->subselect($key, $service->one($key)->select());
        }

        if (empty($attached)) {
            return;
        }

        foreach ($attached as $key => $options) {
            $idKey  = $subKey = $this->resolveSubKey($key . '_id', $options);
            $subIds = array();

            foreach ($rows as &$row) {

                is_array($row[$key]) or
                    $row[$key] = array();

                empty($row[$idKey]) or
                    $subIds[$row[$idKey]] = $row[$idKey];
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

                empty($row[$idKey]) || empty($subItems[$row[$idKey]]) or
                    $row[$key] = $subItems[$row[$idKey]];
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
                // temporary fix, when one to many make it just update instead of delete all associations
                !$manyToMany ? '_id' : 'id'
            );

            if (empty($values)) {
                continue;
            }

            foreach ($values as $value) {

                $manyToMany or
                    $value[$tableName . '_id'] = $mainId;

                $subService->exchangeArray($value);

                if ($manyToMany) {
                    $subId = !empty($value['id']) ? $value['id'] : $subService->getLastInsertValue();

                    // create association
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
        $attached = array();

        foreach (array_keys($columns) as $key) {
            if (!$service->hasMany($key)) {
                continue;
            }

            $options = $service->manyOptions($key);

            if ($this->relationsDisabled($options)) {
                continue;
            }

            $attached[$key] = $options;

            $select->subselect($key) or
                $select->subselect($key, $service->many($key)->select());
        }

        if (empty($attached)) {
            return;
        }

        $mainIds   = array_keys($rows->getArrayCopy());
        $tableName = $service->getTableName();

        foreach ($attached as $key => $options) {

            $subSelect  = clone $select->subselect($key);
            $subService = $service->many($key);

            // decide relation
            $subKey = $this->resolveSubKey($tableName, $options);
            if ($subService->hasMany($subKey)) {
                // bidirectional
                $mainKey = $tableName . 'id';
                $this->assocJoin($subSelect, $service, $subService, $options);
            } else {
                // oneway
                $mainKey = $tableName . '_id';
            }

            $subSelect->where(new SqlIn($mainKey, $mainIds));

            $limit = $subSelect->getLimit();
            $subSelect->reset('limit');

            $subItems = $subService->fetchWith($subSelect);

            foreach ($rows as &$row) {

                is_array($row[$key]) or
                    $row[$key] = array();

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

        $sql = 'INSERT IGNORE INTO ' . $qi($assocTableName)
             . ' (' . $qi($tableName . 'id') . ', ' . $qi($subTableName . 'id') . ')'
             . ' VALUES (' . $qv($mainId) . ', ' . $qv($subId) . ')';

        $this->adapter->query($sql)->execute();
    }

    protected function assocDelete(DataService $service, DataService $subService, $mainId, array $options, $idSuffix = 'id')
    {
        $platform = $service->getPlatform();

        $qi = function($name) use ($platform) { return $platform->quoteIdentifier($name); };
        $qv = function($name) use ($platform) { return $platform->quoteValue($name); };

        $tableName      = $service->getTableName();
        $subTableName   = $subService->getTableName();
        $assocTableName = $this->resolveAssocTableName($tableName, $subTableName, $options);

        $sql = 'DELETE FROM ' . $qi($assocTableName)
             . ' WHERE ' . $qi($tableName . $idSuffix) . ' = ' . $qv($mainId);

        $this->adapter->query($sql)->execute();
    }

    protected function assocJoin($select, DataService $service, DataService $subService, array $options)
    {
        // todo DRY
        $tableName      = $service->getTableName();
        $subTableName   = $subService->getTableName();
        $assocTableName = $this->resolveAssocTableName($tableName, $subTableName, $options);

        $select->join($assocTableName, $subTableName . '.id=' . $assocTableName . '.' . $subTableName . 'id');
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
        return array_key_exists('relations', $options)
                && false === $options['relations'];
    }
}
