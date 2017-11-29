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

/**
 * Trait PurgeTrait
 */
trait PurgeTrait
{
    use TraitBase;

    /**
     * @param \Zend\Db\Sql\Where|\Closure|string|array $where
     * @return int Affected rows
     */
    public function delete($where = null)
    {
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $_where = $where ? $where : 1;
        $event->setArguments([$_where]);
        $events->trigger($event::EVENT_DELETE, $event);

        if ($event->propagationIsStopped()) {
            return 0;
        }

        $affectedRows = $this->getTable()->delete($_where);
        $event->setAffectedRows($affectedRows);
        $events->trigger($event::EVENT_DELETE_POST, $event);
        return $affectedRows;
    }
}
