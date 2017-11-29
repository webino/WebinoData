<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Select;

use ArrayObject;
use Zend\Db\Sql\Predicate\PredicateSet;

/**
 * Class Where
 */
class Where extends AbstractHelper
{
    use PredicateTrait;

    /**
     * @return \WebinoData\Store\StoreInterface
     */
    public function getStore()
    {
        return $this->select->getStore();
    }

    /**
     * @see DataSelect::whereAnd();
     * @see DataSelect::whereOr();
     *
     * @param mixed $predicate
     * @param string $combination
     * @return $this
     */
    public function where($predicate, $combination = PredicateSet::OP_AND)
    {
        is_object($predicate)
            or $predicate = new ArrayObject((array) $predicate);

        $store = $this->select->getStore();
        $event = $store->getEvent();

        $event
            ->setSelect($this->select)
            ->setStore($store)
            ->setWherePredicate($predicate)
            ->setWhereCombination($combination);

        $store->getEventManager()->trigger($event::EVENT_SELECT_WHERE, $event);

        $this->select->getSqlSelect()->where(
            $this->handlePredicate($event->getWherePredicate()),
            $event->getWhereCombination()
        );

        return $this;
    }
}
