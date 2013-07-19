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

                $select->addColumn($key, $key . '_id');
                continue;
            }

            if (!$service->hasMany($key)) {
                continue;
            }

            $options = $service->manyOptions($key);

            if ($this->relationsDisabled($options)) {
                continue;
            }

            $subservice = $service->many($key);
            $subselect  = $subservice->configSelect($column);

            if ($subselect) {
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

            foreach ($rows as $row) {
                $attached[$key][$row[$key]] = $row[$key];
            }
        }

        if (empty($attached)) {
            return;
        }

        foreach ($attached as $key => $subIds) {

            $subselect  = clone $select->subselect($key);
            $subservice = $service->one($key);

            $subselect->where(new SqlIn('id', $subIds));

            $subItems = $subservice->fetchWith($subselect);

            foreach ($rows as &$row) {
                $row[$key] = $subItems[$row[$key]];
            }
        }
    }

    protected function compositeExchange(DataEvent $event)
    {
        $service = $event->getService();
        $data    = $event->getData();

        $mainId = $service->getLastInsertValue();

        foreach ($data->getArrayCopy() as $key => $values) {

            if (!$service->hasMany($key)) {
                continue;
            }

            $options = $service->manyOptions($key);

            if ($this->relationsDisabled($options)) {
                continue;
            }

            $subservice = $service->many($key);

            foreach ($values as $value) {

                $subservice->exchangeArray($value);

                // create association
                $this->assocInsert(
                    $service,
                    $subservice,
                    $mainId,
                    $subservice->getLastInsertValue()
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
        $mainKey   = $tableName . '_id';

        foreach ($attached as $key) {

            $subselect  = clone $select->subselect($key);
            $subservice = $service->many($key);

            $subselect->where(new SqlIn($mainKey, $mainIds));

            // todo composition key instead of tableName
            !$subservice->hasMany($tableName) or
                $this->assocJoin($subselect, $service, $subservice);

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

        $mainKey = $service->getTableName();
        $subKey  = $subservice->getTableName();

        $sql = 'INSERT INTO ' . $qi($mainKey . '_' . $subKey)
             . ' (' . $qi($mainKey . 'id') . ', ' . $qi($subKey . 'id') . ')'
             . ' VALUES (' . $qv($mainId) . ', ' . $qv($subId) . ')';

        $this->adapter
             ->query($sql)
             ->execute();
    }

    protected function assocJoin($select, DataService $service, DataService $subservice)
    {
        $mainKey = $service->getTableName();
        $subKey  = $subservice->getTableName();
        $name    = $mainKey . '_' . $subKey;

        $select->join($name, $subKey . '.id=' . $name . '.' . $subKey . 'id');
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
