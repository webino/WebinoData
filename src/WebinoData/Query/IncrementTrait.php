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
 * Trait IncrementTrait
 */
trait IncrementTrait
{
    use Store\TraitBase;

    /**
     * @var Increment
     */
    private $incrementQuery;

    /**
     * @return Increment
     */
    protected function getIncrementQuery()
    {
        if (null === $this->incrementQuery) {
            $this->setIncrementQuery(
                new Increment(
                    $this->getSql()->update(),
                    $this->getPlatform()
                )
            );
        }
        return $this->incrementQuery;
    }

    /**
     * @param Increment $query
     * @return $this
     */
    public function setIncrementQuery(Increment $query)
    {
        $this->incrementQuery = $query;
        return $this;
    }

    /**
     * @param string|array $column
     * @param mixed $where
     * @return mixed
     */
    public function increment($column, $where)
    {
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event->setArguments([$column, $where]);
        $events->trigger($event::EVENT_INCREMENT, $event);

        $query = new Increment(
            $this->getSql()->update(),
            $this->getPlatform()
        );

        $query
            ->setColumns($column)
            ->where($where);

        $result = $this->executeQuery($query);
        $event->setAffectedRows($result->getAffectedRows());
        $events->trigger($event::EVENT_INCREMENT_POST, $event);

        return $result;
    }
}
