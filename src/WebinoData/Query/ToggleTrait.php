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
 * Trait ToggleTrait
 */
trait ToggleTrait
{
    use Store\TraitBase;

    /**
     * @var Toggle
     */
    private $toggleQuery;

    /**
     * @return Toggle
     */
    protected function getToggleQuery()
    {
        if (null === $this->toggleQuery) {
            $this->setToggleQuery(
                new Toggle(
                    $this->getSql()->update(),
                    $this->getPlatform()
                )
            );
        }
        return $this->toggleQuery;
    }

    /**
     * @param Toggle $query
     * @return $this
     */
    public function setToggleQuery(Toggle $query)
    {
        $this->toggleQuery = $query;
        return $this;
    }

    /**
     * @param string $column
     * @param mixed $where
     * @return mixed
     */
    public function toggle($column, $where)
    {
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event->setArguments([$column, $where]);
        $events->trigger($event::EVENT_TOGGLE, $event);

        $query = new Toggle(
            $this->getSql()->update(),
            $this->getPlatform()
        );

        $query
            ->setColumns($column)
            ->where($where);

        $result = $this->executeQuery($query);
        $event->setAffectedRows($result->getAffectedRows());
        $events->trigger($event::EVENT_TOGGLE_POST, $event);

        return $result;
    }
}
