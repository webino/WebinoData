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
 * Class TraitBase
 */
trait TraitBase
{
    /**
     * @return void
     */
    abstract protected function init();

    /**
     * @return array
     */
    abstract public function getConfig();

    /**
     * Returns database adapter
     *
     * @return \Zend\Db\Adapter\Adapter|\Zend\Db\Adapter\AdapterInterface
     */
    abstract public function getAdapter();

    /**
     * @return \Zend\Db\TableGateway\TableGateway
     */
    abstract protected function getTable();

    /**
     * @return \Zend\Db\Sql\Sql
     */
    abstract public function getSql();

    /**
     * @return \Zend\Db\Adapter\Platform\PlatformInterface
     */
    abstract public function getPlatform();

    /**
     * @deprecated use StoreManager instead (TODO)
     * @TODO remove, deprecated, create StoreManager instead of ServiceManager usage
     * @return \Zend\ServiceManager\ServiceManager
     */
    abstract public function getServiceManager();

    /**
     * @return \Zend\EventManager\EventManagerInterface
     */
    abstract public function getEventManager();

    /**
     * @return \WebinoData\Event\DataEvent
     */
    abstract public function getEvent();

    /**
     * @return \WebinoData\Event\DataEvent
     */
    abstract protected function createEvent();

    /**
     * @param string $query
     * @param null|array|\Zend\Db\Adapter\ParameterContainer $params
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    abstract public function executeQuery($query, $params = null);

    /**
     * @return int
     */
    abstract public function getLastInsertValue();
}
