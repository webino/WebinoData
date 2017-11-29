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

use WebinoData\Event\DataEvent;
use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Db\Sql;

/**
 * Class QueryTraitBase
 */
trait TraitBase
{
    /**
     * @return void
     */
    abstract protected function init();

    /**
     * Returns database adapter
     *
     * @return \Zend\Db\Adapter\Adapter|\Zend\Db\Adapter\AdapterInterface
     */
    abstract public function getAdapter();

    /**
     * @return Sql\Sql
     */
    abstract public function getSql();

    /**
     * @return PlatformInterface
     */
    abstract public function getPlatform();

    /**
     * @return EventManagerInterface
     */
    abstract public function getEventManager();

    /**
     * @return DataEvent
     */
    abstract public function getEvent();

    /**
     * @param string $query
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    abstract public function executeQuery($query);
}
