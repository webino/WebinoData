<?php

namespace WebinoData\DataPlugin;

use WebinoData\DataSelect;
use WebinoData\DataService;
use WebinoData\DataSelect\ArrayColumn;
use WebinoData\Exception;
use WebinoData\Event\DataEvent;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Expression as SqlExpression;
use Zend\EventManager\EventManager;

/**
 * Class Relations
 */
final class Relations
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

    /**
     * @param EventManager $eventManager
     */
    public function attach(EventManager $eventManager)
    {
        $eventManager->attach('data.exchange.pre', [$this, 'exchangeOne'], 500);
        $eventManager->attach('data.exchange.invalid', [$this, 'exchangeOne'], 500);
        $eventManager->attach('data.exchange.post', [$this, 'exchangeMany'], 500);
        $eventManager->attach('data.fetch.pre', [$this, 'fetch'], 500);
        $eventManager->attach('data.fetch.post', [$this, 'fetchOne'], 500);
        $eventManager->attach('data.fetch.post', [$this, 'fetchMany'], 500);
    }

    /**
     * Prepare fetch
     *
     * @param DataEvent $event
     */
    public function fetch(DataEvent $event)
    {
        $service = $event->getStore();
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
                    $select->subSelect($key, $subSelect);
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
                $select->subSelect($key, $subSelect);
            }

            $select->addColumn($key, new SqlExpression('\'0\''));
        }
    }

    /**
     * Exchange One to One
     *
     * @param DataEvent $event
     */
    public function exchangeOne(DataEvent $event)
    {
        $service   = $event->getStore();
        $data      = $event->getData();
        $validData = $event->getValidData();

        foreach ($data->getArrayCopy() as $key => $value) {
            if (!$service->hasOne($key) || !is_array($value)) {
                continue;
            }

            $options = $service->oneOptions($key);
            if ($this->relationsDisabled($options)) {
                continue;
            }

            /** @var DataService $subService */
            $subService = $service->one($key);
            $subService->exchangeArray($value);

            $idKey = $this->resolveSubKey($key, $options) . '_id';
            $data[$idKey] = !empty($value['id']) ? $value['id'] : $subService->getLastInsertValue();
            $validData[$idKey] = $data[$idKey];
        }
    }

    /**
     * Fetch One to One
     *
     * @param DataEvent $event
     */
    public function fetchOne(DataEvent $event)
    {
        $rows = $event->getRows();
        if (0 === $rows->count()) {
            return;
        }

        $service  = $event->getStore();
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

            $select->subSelect($key)
                or $select->subSelect($key, $service->one($key)->select());
        }

        if (empty($attached)) {
            return;
        }

        foreach ($attached as $key => $options) {
            $idKey  = $this->resolveSubKey($key, $options) . '_id';
            $subIds = [];

            foreach ($rows as &$row) {
                is_array($row[$key]) or $row[$key] = [];
                empty($row[$idKey])  or $subIds[$row[$idKey]] = $row[$idKey];
            }

            if (empty($subIds)) {
                continue;
            }

            /** @var DataSelect $subSelect */
            $subSelect  = clone $select->subSelect($key);
            /** @var DataService $subService */
            $subService = $service->one($key);
            $tableName  = $subService->getTableName();

            $subSelect->where([$tableName . '.id' => $subIds]);
            $subItems = $subService->fetchWith($subSelect);

            foreach ($rows as &$row) {

                empty($row[$idKey]) || empty($subItems[$row[$idKey]])
                    or $row[$key] = $subItems[$row[$idKey]];
            }
        }
    }

    /**
     * Exchange One/Many to Many
     *
     * @param DataEvent $event
     */
    public function exchangeMany(DataEvent $event)
    {
        $service   = $event->getStore();
        $tableName = $service->getTableName();
        $data      = $event->getData();
        $mainId    = !empty($data['id']) ? $data['id'] : $service->getLastInsertValue();

        foreach ($data->getArrayCopy() as $key => $_values) {
            if (!$service->hasMany($key)) {
                continue;
            }

            $values  = is_array($_values) ? $_values : explode(PHP_EOL, $_values);
            $options = $service->manyOptions($key);

            if ($this->relationsDisabled($options)) {
                continue;
            }

            $subService = $service->many($key);

            if (!isset($values)) {
                continue;
            }

            $subKey = $this->resolveSubKey($tableName, $options);
            $subOptions = $subService->hasMany($subKey) ? $subService->manyOptions($subKey) : [];

            $manyToMany = array_key_exists('oneToMany', $options)
                        ? !$options['oneToMany']
                        : true;

            $this->assocDelete(
                $service,
                $subService,
                $mainId,
                $options,
                $subOptions,
                (array) array_filter(array_column($values, 'id')),
                $manyToMany
            );

            $event->setAffectedRows($event->getAffectedRows() + 1);

            if (empty($values)) {
                continue;
            }

            foreach ($values as $value) {
                $valueIsNumeric = is_numeric($value);

                if (!$valueIsNumeric) {
                    $assocSubKey = $subKey . '_id';
                    $manyToMany or $value[$assocSubKey] = $mainId;

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
                        $options,
                        $subOptions
                    );
                }
            }
        }
    }

    /**
     * Fetch One/Many to Many
     *
     * @param DataEvent $event
     * @throws Exception\RelationException|\Exception
     */
    public function fetchMany(DataEvent $event)
    {
        $rows = $event->getRows();
        if (0 === $rows->count()) {
            return;
        }

        $service  = $event->getStore();
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

            $select->subSelect($key)
                or $select->subSelect($key, $service->many($key)->select());
        }

        if (empty($attached)) {
            return;
        }

        $mainIds   = array_keys($rows->getArrayCopy());
        $tableName = $service->getTableName();

        foreach ($attached as $key => $options) {

            /** @var DataSelect $subSelect */
            $subSelect  = clone $select->subSelect($key);
            $subService = $service->many($key);
            // TODO, for BC only (remove deprecated)
            $keySuffix  = '_id';

            // decide relation
            $subKey   = $this->resolveSubKey($tableName, $options);
            $biDirect = $subService->hasMany($subKey);

            if ($biDirect) {
                // bi-directional
                // TODO, for BC only (remove deprecated)
                $keySuffix  = isset($options['keySuffix']) ? $options['keySuffix'] : 'id';
                $subOptions = $subService->manyOptions($subKey);

                $this->assocJoin($subSelect, $service, $subService, $subOptions);
            }

            $mainKey = $this->resolveSubKey($tableName, $options) . $keySuffix;
            $subSelect->where([$mainKey => $mainIds]);

            $limit = $subSelect->getLimit();
            $subSelect->reset('limit');

            try {
                $subItems = $subService->fetchWith($subSelect, $select->subParams($key));
            } catch (\Exception $exc) {
                if ($biDirect) {
                    throw $exc;
                }

                throw new Exception\RelationException(
                    sprintf('`%s` has not `%s`', $subService->getTableName(), $subKey)
                );
            }

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

    /**
     * @param DataService $service
     * @param DataService $subService
     * @param int $mainId
     * @param int $subId
     * @param array $options
     * @param array $subOptions
     */
    private function assocInsert(
        DataService $service,
        DataService $subService,
        $mainId,
        $subId,
        array $options,
        array $subOptions
    ) {
        $platform = $service->getPlatform();

        $qi = function($name) use ($platform) { return $platform->quoteIdentifier($name); };
        $qv = function($name) use ($platform) { return $platform->quoteValue($name); };

        $tableName      = $service->getTableName();
        $subTableName   = $subService->getTableName();
        $assocTableName = $this->resolveAssocTableName($tableName, $subTableName, $options);

        $key = $this->resolveSubKey($tableName, $options);
        $subKey = $this->resolveSubKey($subTableName, $subOptions);
        // TODO, for BC only (remove deprecated)
        $keySuffix = isset($options['keySuffix']) ? $options['keySuffix'] : 'id';

        $sql = sprintf(
            'INSERT IGNORE INTO %s (%s, %s) VALUES (%s, %s)',
            $qi($assocTableName),
            $qi($key . $keySuffix),
            $qi($subKey . $keySuffix),
            $qv($mainId),
            $qv($subId)
        );

        $this->adapter->query($sql)->execute();
    }

    /**
     * @param DataService $service
     * @param DataService $subService
     * @param int $mainId
     * @param array $options
     * @param array $subOptions
     * @param array $idsExclude
     * @param $manyToMany
     */
    private function assocDelete(
        DataService $service,
        DataService $subService,
        $mainId,
        array $options,
        array $subOptions,
        array $idsExclude = [],
        $manyToMany
    ) {
        $platform = $service->getPlatform();

        $qi = function($name) use ($platform) { return $platform->quoteIdentifier($name); };
        $qv = function($name) use ($platform) { return $platform->quoteValue($name); };

        $tableName      = $service->getTableName();
        $subTableName   = $subService->getTableName();
        $assocTableName = $this->resolveAssocTableName($tableName, $subTableName, $options);

        $key = $this->resolveSubKey($tableName, $options);
        $subKey = $this->resolveSubKey($subTableName, $subOptions);
        // TODO, for BC only (remove deprecated)
        $keySuffix = $manyToMany ? (isset($options['keySuffix']) ? $options['keySuffix'] : 'id') : '_id';
        $sql = sprintf('DELETE FROM %s WHERE %s=%s', $qi($assocTableName), $qi($key . $keySuffix), $qv($mainId));

        // exclude ids to update
        empty($idsExclude)
            or $sql.= sprintf(
                ' AND %s NOT IN (%s)',
                $manyToMany ? $qi($subKey . $keySuffix) : 'id',
                join(',', $idsExclude)
            );

        $this->adapter->query($sql)->execute();
    }

    /**
     * @param DataSelect $select
     * @param DataService $service
     * @param DataService $subService
     * @param array $options
     */
    private function assocJoin($select, DataService $service, DataService $subService, array $options)
    {
        // todo DRY
        $tableName      = $service->getTableName();
        $subTableName   = $subService->getTableName();
        $assocSubKey    = $this->resolveSubKey($subTableName, $options);
        $assocTableName = $this->resolveAssocTableName($tableName, $subTableName, $options);

        // TODO, for BC only (remove deprecated)
        $keySuffix = isset($options['keySuffix']) ? $options['keySuffix'] : 'id';
        $select->join($assocTableName, $subTableName . '.id=' . $assocTableName . '.' . $assocSubKey . $keySuffix);
    }

    /**
     * @param string $tableName
     * @param array $options
     * @return mixed
     */
    private function resolveSubKey($tableName, array $options)
    {
        return !empty($options['key']) ? $options['key'] : $tableName;
    }

    /**
     * @param string $tableName
     * @param string $subTableName
     * @param array $options
     * @return string
     */
    private function resolveAssocTableName($tableName, $subTableName, array $options)
    {
        return !empty($options['tableName']) ? $options['tableName'] : $tableName . '_' . $subTableName;
    }

    /**
     * Return true when relations are disabled by options
     *
     * @param array $options
     * @return bool
     */
    private function relationsDisabled(array $options)
    {
        return array_key_exists('relations', $options) && false === $options['relations'];
    }
}
