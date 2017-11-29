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

use WebinoData\Exception;
use WebinoData\InputFilter\InputFilterFactoryAwareInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

/**
 * Class AbstractStore
 */
abstract class AbstractStore implements
    EventManagerAwareInterface,
    ServiceManagerAwareInterface,
    InputFilterFactoryAwareInterface,
    StoreInterface
{
    use EventsTrait;
    use InputTrait;
    use OutputTrait;
    use SyncTrait;
    use QueryTrait;
    use PurgeTrait;
    use PluginTrait;
    use SelectTrait;
    use SchemaTrait;
    use RelationsTrait;

    /**
     * @var bool
     */
    protected $initialized = false;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var TableGateway
     */
    protected $table;

    /**
     * @todo rename to StoreManager
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @param TableGateway $table
     * @param array $config
     */
    public function __construct(TableGateway $table, array $config)
    {
        $this->table  = $table;
        $this->config = $config;
    }

    /**
     * Lazy initialization
     *
     * @return void
     */
    protected function init()
    {
        if ($this->initialized) {
            return;
        }
        $this->initialized = true;

        // init plugins
        empty($this->config['plugin'])
            or $this->initPlugin($this->config['plugin']);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdapter()
    {
        return $this->table->getAdapter();
    }

    /**
     * {@inheritdoc}
     */
    public function getSql()
    {
        return $this->table->getSql();
    }

    /**
     * {@inheritdoc}
     */
    public function getPlatform()
    {
        return $this->getAdapter()->getPlatform();
    }

    /**
     * @return TableGateway
     */
    protected function getTable()
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->table->getTable();
    }

    /**
     * @deprecated use StoreManager instead (TODO)
     * @TODO remove, deprecated, create StoreManager instead of ServiceManager usage
     * @return ServiceManager
     * @throws Exception\RuntimeException
     */
    public function getServiceManager()
    {
        if (null === $this->serviceManager) {
            // TODO exception
            throw new Exception\RuntimeException('Expected serviceManager injected');
        }
        return $this->serviceManager;
    }

    /**
     * @deprecated use StoreManager instead (TODO)
     * @TODO remove, deprecated, create StoreManager instead of ServiceManager usage
     * @param ServiceManager $serviceManager
     * @return $this
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    /**
     * @return void
     */
    public function __clone()
    {
        $this->event and $this->event = clone $this->event;
        $this->inputFilter and $this->inputFilter = clone $this->inputFilter;
    }
}
