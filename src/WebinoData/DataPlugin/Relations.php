<?php

namespace WebinoData\DataPlugin;

use WebinoData\DataEvent;
use WebinoData\DataService;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Expression as SqlExpression;
use Zend\Db\Sql\Predicate\In as SqlIn;

class Relations
{
    protected $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function attach($eventManager)
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

        foreach ($columns as $key => &$column) {

            if ($service->hasOne($key)) {

                $options = $service->oneOptions($key);

                if ($this->relationsDisabled($options)) {
                    continue;
                }

                if (is_string($column)) {
                    $subselect = $service->one($key)->configSelect($column);
                    $select->subselect($key, $subselect);
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

            if (is_string($column)) {
                $subselect = $service->many($key)->configSelect($column);
                $select->subselect($key, $subselect);
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

            $subservice = $service->one($key);

            $subservice->exchangeArray($value);

            unset($data[$key]);

            if (!empty($value['id'])) {
                $id = $value['id'];
            } else {
                $id = $subservice->getLastInsertValue();
            }

            $validData[$key . '_id'] = $id;
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

            $attached[$key] = array();

            $subselect = $select->subselect($key);

            $subselect or
                $select->subselect($key, $service->one($key)->select());

            foreach ($rows as $row) {
                $idKey = $key . '_id';

                empty($row[$idKey]) or
                    $attached[$key][$row[$idKey]] = $row[$idKey];
            }
        }

        if (empty($attached)) {
            return;
        }

        foreach ($attached as $key => $subIds) {

            $subselect  = clone $select->subselect($key);
            $subservice = $service->one($key);
            $tableName  = $subservice->getTableName();

            $subselect->where(new SqlIn($tableName . '.id', $subIds));

            $subItems = $subservice->fetchWith($subselect);

            foreach ($rows as &$row) {
                $idKey = $key . '_id';
                $row[$key] = $subItems[$row[$idKey]];
            }
        }
    }

    protected function compositeExchange(DataEvent $event)
    {
        $service = $event->getService();
        $data    = $event->getData();

        $mainId = !empty($data['id']) ? $data['id'] : $service->getLastInsertValue();

        foreach ($data->getArrayCopy() as $key => $values) {

            if (!$service->hasMany($key)) {
                continue;
            }

            $options = $service->manyOptions($key);

            if ($this->relationsDisabled($options)) {
                continue;
            }

            $subservice = $service->many($key);

            if (!isset($values)) {
                continue;
            }

            // delete association
            $this->assocDelete(
                $service,
                $subservice,
                $mainId
            );

            if (empty($values)) {
                continue;
            }

            foreach ($values as $value) {

                $subservice->exchangeArray($value);

                // create association
                $this->assocInsert(
                    $service,
                    $subservice,
                    $mainId,
                    !empty($value['id']) ? $value['id'] : $subservice->getLastInsertValue()
                );
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

            $attached[$key] = $key;

            $subselect = $select->subselect($key);

            $subselect or
                $select->subselect($key, $service->many($key)->select());
        }

        if (empty($attached)) {
            return;
        }

        $mainIds   = array_keys($rows->getArrayCopy());
        $tableName = $service->getTableName();

        foreach ($attached as $key) {

            $subselect  = clone $select->subselect($key);
            $subservice = $service->many($key);

            // todo composition key instead of tableName
            if ($subservice->hasMany($tableName)) {
                $mainKey = $tableName . 'id';
                $this->assocJoin($subselect, $service, $subservice);
            } else {
                $mainKey = $tableName . '_id';
            }

            $subselect->where(new SqlIn($mainKey, $mainIds));

            // limit
            $limit = $subselect->getLimit();
            $subselect->reset('limit');

            $subItems = $subservice->fetchWith($subselect);

            foreach ($subItems as $subItem) {

                $mainId = $subItem[$mainKey];

                is_array($rows[$mainId][$key]) or
                    $rows[$mainId][$key] = array();

                if ($limit && $limit <= count($rows[$mainId][$key])) {
                    continue;
                }

                $rows[$mainId][$key][] = $subItem;
            }
        }
    }

    protected function assocInsert(DataService $service, DataService $subservice, $mainId, $subId)
    {
        $platform = $service->getPlatform();

        $qi = function($name) use ($platform) { return $platform->quoteIdentifier($name); };
        $qv = function($name) use ($platform) { return $platform->quoteValue($name); };

        $mainKey   = $service->getTableName();
        $subKey    = $subservice->getTableName();
        $options   = $service->manyOptions($subKey);
        $tableName = !empty($options['tableName']) ? $options['tableName'] : $mainKey . '_' . $subKey;

        $sql = 'INSERT IGNORE INTO ' . $qi($tableName)
             . ' (' . $qi($mainKey . 'id') . ', ' . $qi($subKey . 'id') . ')'
             . ' VALUES (' . $qv($mainId) . ', ' . $qv($subId) . ')';

        $this->adapter
             ->query($sql)
             ->execute();
    }

    protected function assocDelete(DataService $service, DataService $subservice, $mainId)
    {
        $platform = $service->getPlatform();

        $qi = function($name) use ($platform) { return $platform->quoteIdentifier($name); };
        $qv = function($name) use ($platform) { return $platform->quoteValue($name); };

        $mainKey   = $service->getTableName();
        $subKey    = $subservice->getTableName();
        $options   = $service->manyOptions($subKey);
        $tableName = !empty($options['tableName']) ? $options['tableName'] : $mainKey . '_' . $subKey;

        $sql = 'DELETE FROM ' . $qi($tableName)
             . ' WHERE ' . $qi($mainKey . 'id') . ' = ' . $qv($mainId);

        $this->adapter
             ->query($sql)
             ->execute();
    }

    protected function assocJoin($select, DataService $service, DataService $subservice)
    {
        $mainKey   = $service->getTableName();
        $subKey    = $subservice->getTableName();
        $options   = $service->manyOptions($subKey);
        $tableName = !empty($options['tableName']) ? $options['tableName'] : $mainKey . '_' . $subKey;

        $select->join($tableName, $subKey . '.id=' . $tableName . '.' . $subKey . 'id');
    }

    /**
     * Return true when relations are enabled by options
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
