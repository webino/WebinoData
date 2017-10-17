<?php

namespace WebinoData\Select;

use ArrayObject;
use WebinoData\Event\DataEvent;
use Zend\Db\Sql\Predicate\PredicateSet;

/**
 * Class Where
 */
class Where extends AbstractHelper
{
    use PredicateTrait;

    /**
     * @return \WebinoData\AbstractDataService
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
            ->setParam('predicate', $predicate)
            ->setParam('combination', $combination);

        $store->getEventManager()->trigger(DataEvent::EVENT_SELECT_WHERE, $event);
        $this->select->getSqlSelect()->where($this->parsePredicate($predicate), $combination);

        return $this;
    }
}
