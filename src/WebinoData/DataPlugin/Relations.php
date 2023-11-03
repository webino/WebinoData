<?php

namespace WebinoData\DataPlugin;

use WebinoData\DataSelect;
use WebinoData\DataService;
use WebinoData\DataSelect\ArrayColumn;
use WebinoData\Exception;
use WebinoData\Event\DataEvent;
use WebinoData\Store\StoreAwareInterface;
use WebinoData\Store\StoreAwareTrait;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Exception\InvalidQueryException;
use Zend\Db\Sql\Expression as SqlExpression;
use Zend\EventManager\EventManager;

/**
 * Class Relations
 */
final class Relations implements StoreAwareInterface
{
    use StoreAwareTrait;

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
     * @param EventManager $events
     */
    public function attach(EventManager $events)
    {
        $events->attach(DataEvent::EVENT_SELECT_COLUMNS, [$this, 'selectColumns'], 500);
        $events->attach(DataEvent::EVENT_EXCHANGE_PRE, [$this, 'exchangeOne'], 500);
        $events->attach(DataEvent::EVENT_EXCHANGE_INVALID, [$this, 'exchangeOne'], 500);
        $events->attach(DataEvent::EVENT_EXCHANGE_POST, [$this, 'exchangeMany'], 500);
        $events->attach(DataEvent::EVENT_FETCH_POST, [$this, 'fetchOne'], 500);
        $events->attach(DataEvent::EVENT_FETCH_POST, [$this, 'fetchMany'], 500);
    }

    /**
     * @param string $subStoreName
     * @return bool
     */
    public function isEnabledFor($subStoreName)
    {
        $store   = $this->getStore();
        $options = [];

        if ($store->hasOne($subStoreName)) {
            $options = $store->oneOptions($subStoreName);
        }

        if ($store->hasMany($subStoreName)) {
            $options = $store->manyOptions($subStoreName);
        }

        return !$this->relationsDisabled($options);
    }

    /**
     * Select columns
     *
     * @param DataEvent $event
     */
    public function selectColumns(DataEvent $event)
    {
        $store   = $event->getStore();
        $select  = $event->getSelect();
        $columns = $event->getParam('columns');
        $inputs  = $store->getInputFilter();

        foreach ($columns as $key => $column) {
            if ($store->hasOne($key)) {

                $options = $store->oneOptions($key);
                if ($this->relationsDisabled($options)) {
                    continue;
                }

                if (is_string($column) || $column instanceof ArrayColumn) {
                    if (is_string($column)) {
                        $subSelect = $store->one($key)->configSelects($column);
                    } else {
                        $subSelect = $store->one($key)->configSelect((array) $column);
                    }
                    $select->setSubSelect($key, $subSelect);
                }

                $columns[$key] = $inputs->has($key) ? $key : new SqlExpression("'0'");
                continue;
            }

            if (!$store->hasMany($key)) {
                continue;
            }

            $options = $store->manyOptions($key);
            if ($this->relationsDisabled($options)) {
                continue;
            }

            if (is_string($column) || $column instanceof ArrayColumn) {
                if (is_string($column)) {
                    $subSelect = $store->many($key)->configSelects($column);
                } else {
                    $subSelect = $store->many($key)->configSelect((array) $column);
                }
                $select->setSubSelect($key, $subSelect);
            }

            $columns[$key] = new SqlExpression("'0'");
        }

        // TODO remove, use array object
        $event->setParam('columns', $columns);
    }

    /**
     * Exchange One to One
     *
     * @param DataEvent $event
     */
    public function exchangeOne(DataEvent $event)
    {
        $store     = $event->getStore();
        $data      = $event->getData();
        $validData = $event->getValidData();

        foreach ($data->getArrayCopy() as $key => $value) {
            if (!$store->hasOne($key) || !is_array($value)) {
                continue;
            }

            $options = $store->oneOptions($key);
            if ($this->relationsDisabled($options)) {
                continue;
            }

            /** @var DataService $subService */
            $subService = $store->one($key);
            $idKey      = $this->resolveSubKey($key, $options) . '_id';

            empty($data[$idKey]) or $value['id'] = $data[$idKey];
            $subService->exchange($value);

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

        $store    = $event->getStore();
        $select   = $event->getSelect();
        $columns  = $select->getColumns();
        $attached = [];

        foreach (array_keys($columns) as $key) {
            if (!$store->hasOne($key)) {
                continue;
            }

            $options = $store->oneOptions($key);
            if ($this->relationsDisabled($options)) {
                continue;
            }

            $attached[$key] = $options;

            $select->getSubSelect($key)
                or $select->setSubSelect($key, $store->one($key)->select());
        }

        if (empty($attached)) {
            return;
        }

        $inputs = $store->getInputFilter();
        foreach ($attached as $key => $options) {

            $subKey   = $this->resolveSubKey($key, $options);
            $index    = !empty($options['index']) ? $options['index'] : 'id';
            $hasIndex = ('id' !== $index);
            $idKey    = $hasIndex && $inputs->has($subKey) ? $subKey : $subKey . '_id';
            $subIds   = [];

            foreach ($rows as &$row) {
                (is_array($row[$key]) || $hasIndex) or $row[$key] = [];
                empty($row[$idKey]) or $subIds[$row[$idKey]] = $row[$idKey];
            }

            if (empty($subIds)) {
                continue;
            }

            /** @var DataSelect $subSelect */
            $subSelect  = clone $select->getSubSelect($key);
            /** @var DataService $subService */
            $subService = $store->one($key);
            $tableName  = $subService->getTableName();

            $subSelect->where([$tableName . '.' . $index => $subIds]);

            if (!$hasIndex) {
                $subItems = $subService->fetchWith($subSelect);
            } else {
                $subItems = [];
                foreach ($subService->fetchWith($subSelect) as $subItem) {
                    $subItems[$subItem[$index]] = $subItem;
                }
            }

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
        $store     = $event->getStore();
        $tableName = $store->getTableName();
        $data      = $event->getData();
        $mainId    = !empty($data['id']) ? $data['id'] : $store->getLastInsertValue();

        foreach ($data->getArrayCopy() as $key => $_values) {
            if (!$store->hasMany($key)) {
                continue;
            }

            $values  = is_array($_values) ? $_values : explode(PHP_EOL, $_values);
            $options = $store->manyOptions($key);

            if ($this->relationsDisabled($options)) {
                continue;
            }

            $subService = $store->many($key);

            if (!isset($values)) {
                continue;
            }

            $subKey = $this->resolveSubKey($tableName, $options);
            $subOptions = $subService->hasMany($subKey) ? $subService->manyOptions($subKey) : [];

            $manyToMany = !array_key_exists('oneToMany', $options) || !$options['oneToMany'];

            $this->assocDelete(
                $store,
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

                    $subService->exchange($value);
                }

                if ($manyToMany) {
                    $subId = $valueIsNumeric
                           ? $value
                           : (!empty($value['id']) ? $value['id'] : $subService->getLastInsertValue());

                    $this->assocInsert(
                        $store,
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

        $store    = $event->getStore();
        $select   = $event->getSelect();
        $columns  = $select->getColumns();
        $attached = [];

        foreach (array_keys($columns) as $key) {
            if (!$store->hasMany($key)) {
                continue;
            }

            $options = $store->manyOptions($key);

            if ($this->relationsDisabled($options)) {
                continue;
            }

            $attached[$key] = $options;

            $select->getSubSelect($key)
                or $select->setSubSelect($key, $store->many($key)->select());
        }

        if (empty($attached)) {
            return;
        }

        $mainIds   = array_keys($rows->getArrayCopy());
        $tableName = $store->getTableName();

        foreach ($attached as $key => $options) {

            /** @var DataSelect $subSelect */
            $subSelect  = clone $select->getSubSelect($key);
            $subService = $store->many($key);
            // TODO, for BC only (remove deprecated)
            $keySuffix  = '_id';

            // decide relation
            $subKey   = $this->resolveSubKey($tableName, $options);
            $biDirect = $subService->hasMany($subKey);

            if ($biDirect) {
                // bi-directional
                // TODO, for BC only (remove deprecated)
                $keySuffix  = $options['keySuffix'] ?? 'id';
                $subOptions = $subService->manyOptions($subKey);

                $this->assocJoin($subSelect, $store, $subService, $subOptions);
            }

            $mainKey = $this->resolveSubKey($tableName, $options) . $keySuffix;
            $subSelect->where([$mainKey => $mainIds]);

            $limit = $subSelect->getLimit();
            $subSelect->resetLimit();

            try {
                $subItems = $subService->fetchWith($subSelect, $select->getSubParams($key));
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
     * @param DataService $store
     * @param DataService $subService
     * @param int $mainId
     * @param int $subId
     * @param array $options
     * @param array $subOptions
     */
    private function assocInsert(
        DataService $store,
        DataService $subService,
        int $mainId,
        int $subId,
        array $options,
        array $subOptions
    ) {
        $tableName      = $store->getTableName();
        $subTableName   = $subService->getTableName();
        $assocTableName = $this->resolveAssocTableName($tableName, $subTableName, $options);

        $key    = $this->resolveSubKey($tableName, $options);
        $subKey = $this->resolveSubKey($subTableName, $subOptions);
        // TODO, for BC only (remove deprecated)
        $keySuffix = $options['keySuffix'] ?? 'id';

        // create sql
        $platform = $store->getPlatform();
        $qi = function ($name) use ($platform) {
            return $platform->quoteIdentifier($name);
        };

        $sql = sprintf(
            'INSERT IGNORE INTO %s (%s, %s) VALUES (?, ?)',
            $qi($assocTableName),
            $qi($key . $keySuffix),
            $qi($subKey . $keySuffix)
        );

        // execute sql
        $this->adapter->query($sql)->execute([$mainId, $subId]);
    }

    /**
     * @param DataService $store
     * @param DataService $subService
     * @param int $mainId
     * @param array $options
     * @param array $subOptions
     * @param array $idsExclude
     * @param bool $manyToMany
     */
    private function assocDelete(
        DataService $store,
        DataService $subService,
        int $mainId,
        array $options,
        array $subOptions,
        array $idsExclude = [],
        bool $manyToMany = false
    ) {
        $tableName      = $store->getTableName();
        $subTableName   = $subService->getTableName();
        $assocTableName = $this->resolveAssocTableName($tableName, $subTableName, $options);

        $key = $this->resolveSubKey($tableName, $options);
        $subKey = $this->resolveSubKey($subTableName, $subOptions);
        // TODO, for BC only (remove deprecated)
        $keySuffix = $manyToMany ? ($options['keySuffix'] ?? 'id') : '_id';

        // create sql
        $platform = $store->getPlatform();

        $qi = function ($name) use ($platform) {
            return $platform->quoteIdentifier($name);
        };

        $sql = sprintf('DELETE FROM %s WHERE %s=?', $qi($assocTableName), $qi($key . $keySuffix));
        $params = [$mainId];

        // exclude ids to update
        if (!empty($idsExclude)) {

            $sql.= sprintf(
                ' AND %s NOT IN (%s)',
                $manyToMany ? $qi($subKey . $keySuffix) : 'id',
                rtrim(str_repeat('?,', count($idsExclude)), ',')
            );

            $params = array_merge($params, $idsExclude);
        }

        // execute sql
        try {
            $this->adapter->query($sql)->execute($params);
        } catch (InvalidQueryException $exc) {
            throw new Exception\InvalidQueryException($sql, $exc->getCode(), $exc);
        };
    }

    /**
     * @param DataSelect $select
     * @param DataService $store
     * @param DataService $subService
     * @param array $options
     */
    private function assocJoin(DataSelect $select, DataService $store, DataService $subService, array $options)
    {
        // todo DRY
        $tableName      = $store->getTableName();
        $subTableName   = $subService->getTableName();
        $assocSubKey    = $this->resolveSubKey($subTableName, $options);
        $assocTableName = $this->resolveAssocTableName($tableName, $subTableName, $options);

        // TODO, for BC only (remove deprecated)
        $keySuffix = $options['keySuffix'] ?? 'id';
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
