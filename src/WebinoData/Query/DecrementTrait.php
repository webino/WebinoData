<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Query;

use WebinoData\Store;

/**
 * Trait DecrementTrait
 */
trait DecrementTrait
{
    use Store\TraitBase;

    /**
     * @var Decrement
     */
    private $decrementQuery;

    /**
     * @return Decrement
     */
    protected function getDecrementQuery()
    {
        if (null === $this->decrementQuery) {
            $this->setDecrementQuery(
                new Decrement(
                    $this->getSql()->update(),
                    $this->getPlatform()
                )
            );
        }
        return $this->decrementQuery;
    }

    /**
     * @param Decrement $query
     * @return $this
     */
    public function setDecrementQuery(Decrement $query)
    {
        $this->decrementQuery = $query;
        return $this;
    }

    /**
     * @param string|array $column
     * @param mixed $where
     * @return mixed
     */
    public function decrement($column, $where)
    {
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event->setArguments([$column, $where]);
        $events->trigger($event::EVENT_DECREMENT, $event);

        $query = new Decrement(
            $this->getSql()->update(),
            $this->getPlatform()
        );

        $query
            ->setColumns($column)
            ->where($where);

        $result = $this->executeQuery($query);
        $event->setAffectedRows($result->getAffectedRows());
        $events->trigger($event::EVENT_DECREMENT_POST, $event);

        return $result;
    }
}
