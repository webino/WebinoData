<?php

namespace WebinoData\Plugin;

use WebinoData\DataService;
use Zend\Db\Adapter\AdapterInterface;
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

    public function preExchange($event)
    {
        $this->associateExchange($event);
    }

    public function postExchange($event)
    {
        $this->compositeExchange($event);
    }

    public function preFetch($event)
    {
        $service = $event->getParam('service');
        $select  = $event->getParam('select');
        $columns = $select->getColumns();

        $columns['id'] = 'id';

        foreach ($columns as $key => &$column) {

            if ($service->hasOne($key)) {
                $column = $key . '_id';
                continue;
            }

            if ($service->hasMany($key)) {
                $column = new \Zend\Db\Sql\Expression('1');
                continue;
            }
        }

        $select->columns($columns);
    }

    public function postFetch($event)
    {
        $this->associateFetch($event);
        $this->compositeFetch($event);
    }

    protected function associateExchange($event)
    {
        $service = $event->getParam('service');
        $data    = $event->getParam('data');

        foreach ($data->getArrayCopy() as $key => $value) {

            if (!$service->hasOne($key)) {
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

            $data[$key . '_id'] = $id;
        }
    }

    protected function associateFetch($event)
    {
        $rows = $event->getParam('rows');

        if (0 === $rows->count()) {
            return;
        }

        $service  = $event->getParam('service');
        $select   = $event->getParam('select');
        $columns  = $select->getColumns();
        $attached = array();

        foreach (array_keys($columns) as $key) {

            if (!$service->hasOne($key)) {
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

    protected function compositeExchange($event)
    {
        $service = $event->getParam('service');
        $data    = $event->getParam('data');

        $mainId = $service->getLastInsertValue();

        foreach ($data->getArrayCopy() as $key => $values) {

            if (!$service->hasMany($key)) {
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

    protected function compositeFetch($event)
    {
        $rows = $event->getParam('rows');

        if (0 === $rows->count()) {
            return;
        }

        $service  = $event->getParam('service');
        $select   = $event->getParam('select');
        $columns  = $select->getColumns();
        $attached = array();

        foreach (array_keys($columns) as $key) {

            if (!$service->hasMany($key)) {
                continue;
            }

            $attached[$key] = $key;
        }

        if (empty($attached)) {
            return;
        }

        $mainIds = array_keys($rows->getArrayCopy());
        $mainKey = $service->getTableName() . 'id';

        foreach ($attached as $key) {

            $subselect  = clone $select->subselect($key);
            $subservice = $service->many($key);

            $subselect->where(new SqlIn($mainKey, $mainIds));

            $this->assocJoin($subselect, $service, $subservice);

            $subItems = $subservice->fetchWith($subselect);

            foreach ($subItems as $subItem) {

                $mainId = $subItem[$mainKey];

                is_array($rows[$mainId][$key]) or
                    $rows[$mainId][$key] = array();

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
}
