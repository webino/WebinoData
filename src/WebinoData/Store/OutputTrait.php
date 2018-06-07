<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Store;

use ArrayObject;
use WebinoData\Paginator;
use WebinoData\Select;

/**
 * Trait OutputTrait
 */
trait OutputTrait
{
    use TraitBase;

    /**
     * @param $selectName
     * @param array $params
     * @return array|ArrayObject
     */
    public function fetch($selectName, $params = [])
    {
        return $this->fetchWith($this->configSelect($selectName), $params);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchWith(Select $select, $params = [])
    {
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event->setSelect($select);
        $events->trigger($event::EVENT_FETCH_PRE, $event);

        $rows = new ArrayObject;
        foreach ($select->execute($params) as $row) {

            if (empty($row['id'])) {
                $rows[] = $row;
            } elseif (empty($rows[$row['id']])) {
                $rows[$row['id']] = $row;
            } else {
                $rows[$row['id'] . '/' . count($rows)] = $row;
            }
        }

        $event->setRows($rows);
        $events->trigger($event::EVENT_FETCH_POST, $event);
        return $event->getRows();
    }

    /**
     * @param Select $select
     * @param array $params
     * @return array
     */
    public function fetchPairs(Select $select, $params = [])
    {
        $data = [];
        foreach ($this->fetchWith($select, $params) as $row) {
            $data[current($row)] = next($row);
        }
        return $data;
    }

    /**
     * @param Select $select
     * @return Paginator
     */
    public function createPaginator(Select $select)
    {
        /** @var StoreInterface $this */
        $paginatorSelect = new Paginator\PaginatorSelect($select, $this);
        return new Paginator($paginatorSelect);
    }
}
