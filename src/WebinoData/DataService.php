<?php

namespace WebinoData;

use WebinoData\DataEvent;
use WebinoData\DataQuery;
use WebinoData\Exception;
use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\Db\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\InputFilter\Factory as InputFilterFactory;
use Zend\InputFilter\InputFilterInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class DataService implements
    EventManagerAwareInterface,
    ServiceManagerAwareInterface
{
    /**
     * @var TableGateway
     */
    protected $tableGateway;

    /**
     * @var array
     */
    protected $config = array();

    /**
     * @var DataEvent
     */
    protected $event;

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var PlatformInterface
     */
    protected $platform;

    /**
     * @var InputFilterFactory
     */
    protected $inputFilterFactory;

    /**
     * @var InputFilterInterface
     */
    protected $inputFilter;

    /**
     * @var array
     */
    protected $subServices = array();

    /**
     * @var type
     */
    protected $initialized = false;


    //todo
    protected $query;


    protected $hasOneList = array();
    protected $hasManyList = array();


    /**
     * @param TableGateway $tableGateway
     * @param array $config
     */
    public function __construct(TableGateway $tableGateway, array $config)
    {
        $this->tableGateway = $tableGateway;
        $this->config       = $config;
    }

    /**
     * @return void
     */
    protected function init()
    {
        if ($this->initialized) {
            return;
        }
        $this->initialized = true;

        empty($this->config['plugin']) or
            $this->initPlugin($this->config['plugin']);
    }

    /**
     * Initialize the data service plugin handlers
     *
     * @param array $config
     * @return DataService
     */
    protected function initPlugin(array $config)
    {
        $serviceManager = $this->getServiceManager();
        $eventManager   = $this->getEventManager();

        foreach ($config as $pluginName) {

            $serviceManager
                ->get($pluginName)
                ->attach($eventManager);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getLastInsertValue()
    {
        return $this->tableGateway->getLastInsertValue();
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableGateway->getTable();
    }

    /**
     * @return DataEvent
     */
    public function getEvent()
    {
        if (null === $this->event) {
            $this->setEvent(new DataEvent);
        }
        return $this->event;
    }

    /**
     * @param DataEvent $event
     * @return DataService
     */
    public function setEvent(DataEvent $event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager);
        }
        return $this->eventManager;
    }

    /**
     * @param EventManagerInterface $eventManager
     * @return DataService
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(
            array(
                __CLASS__,
                'WebinoData',
                $this->getTableName()
            )
        );

        $this->eventManager = $eventManager;
        return $this;
    }

    /**
     * @return ServiceManager
     * @throws Exception
     */
    public function getServiceManager()
    {
        if (null === $this->serviceManager) {
            throw new Exception('Expected serviceManager injected');
        }

        return $this->serviceManager;
    }

    /**
     * @param ServiceManager $serviceManager
     * @return DataService
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    /**
     * @return PlatformInterface
     */
    public function getPlatform()
    {
        if (null === $this->platform) {
            $adapter = $this->getAdapter();
            $this->setPlatform(
                $adapter->getPlatform()->setDriver($adapter->getDriver())
            );
        }
        return $this->platform;
    }

    /**
     * @param PlatformInterface $platform
     * @return DataService
     */
    public function setPlatform(PlatformInterface $platform)
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * @return InputFilterFactory
     */
    public function getInputFilterFactory()
    {
        if (null === $this->inputFilterFactory) {
            $this->setInputFilterFactory(new InputFilterFactory);
        }
        return $this->inputFilterFactory;
    }

    /**
     * @param InputFilterFactory $factory
     * @return DataService
     */
    public function setInputFilterFactory(InputFilterFactory $factory)
    {
        $this->inputFilterFactory = $factory;
        return $this;
    }

    /**
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if (null === $this->inputFilter) {
            $this->setInputFilter(
                $this->getInputFilterFactory()
                     ->createInputFilter($this->config['input_filter'])
            );
        }
        return $this->inputFilter;
    }

    /**
     * @param InputFilterInterface $inputFilter
     * @return DataService
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
        return $this;
    }

    /**
     * @param DataService $service
     * @return DataService
     */
    public function setHasOne($name, DataService $service)
    {
        $this->hasOneList[$name] = $service;
        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasOne($name)
    {
        return !empty($this->hasOneList[$name]);
    }

    /**
     * @param string $name
     * @return DataService
     */
    public function one($name)
    {
        if (empty($this->hasOneList[$name])) {
            throw new \OutOfBoundsException('Hasn\'t one ' . $name);
        }

        return $this->hasOneList[$name];
    }

    /**
     * @param string $name
     * @param DataService $service
     * @return DataService
     */
    public function setHasMany($name, DataService $service)
    {
        $this->hasManyList[$name] = $service;
        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasMany($name)
    {
        return !empty($this->hasManyList[$name]);
    }

    /**
     * @param string $name
     * @return DataService
     * @throws \OutOfBoundsException
     */
    public function many($name)
    {
        if (empty($this->hasManyList[$name])) {
            throw new \OutOfBoundsException('Hasn\'t many ' . $name);
        }

        return $this->hasManyList[$name];
    }

    /**
     * Bind the data service to the form
     *
     * @param object $object Object to bind into
     * @return DataService
     * @throws Exception\InvalidArgumentException
     * @throws Exception\RuntimeException
     */
    public function bind($object)
    {
        if (!is_object($object)) {

            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects an object as an argument; %s provided',
                    __METHOD__,
                    gettype($object)
                )
            );
        }

        if (!method_exists($object, 'bind')) {

            throw new Exception\RuntimeException(
                sprintf(
                    '%s expects an object with bind() method',
                    __METHOD__,
                    gettype($object)
                )
            );
        }

        if (!method_exists($object, 'setInputFilter')) {

            throw new Exception\RuntimeException(
                sprintf(
                    '%s expects an object with setInputFilter() method',
                    __METHOD__,
                    gettype($object)
                )
            );
        }

        $object->bind($this);
        $object->setInputFilter($this->getInputFilter());

        return $this;
    }

    // todo
    public function getQuery()
    {
        if (null === $this->query) {
            $this->setQuery(
                new DataQuery(
                    $this->tableGateway->getSql(),
                    $this->getPlatform()
                )
            );
        }

        return $this->query;
    }

    public function setQuery(DataQuery $query)
    {
        $this->query = $query;
        return $this;
    }

    public function select()
    {
        return new \WebinoData\DataSelect($this->tableGateway->getSql()->select());
    }

    public function configSelect()
    {
        $selectNames = func_get_args();
        $select      = $this->select();

        foreach ($selectNames as $selectName) {

            if (!isset($this->config['select'][$selectName])) {

                throw new Exception\MissingPropertyException(
                    sprintf(
                        'Expected select `%s` in : %s',
                        $selectName,
                        print_r($this->config['select'], 1)
                    )
                );
            }

            $this->configureSelect($select->getSqlSelect(), $this->config['select'][$selectName]);
        }

        return $select;
    }

    public function fetch($selectName, $parameters = array())
    {
        return $this->fetchWith($this->configSelect($selectName), $parameters);
    }

    public function fetchWith(\WebinoData\DataSelect $select, $parameters = array())
    {
        $this->init();

        $events    = $this->getEventManager();
        $dataEvent = $this->getEvent();

        $dataEvent->setParam('service', $this);
        $dataEvent->setParam('select', $select);

        $events->trigger(DataEvent::EVENT_FETCH_PRE, $dataEvent);

        $sqlSelect = $select->getSqlSelect();
        $sql       = $this->tableGateway->getSql();
        $statement = $sql->prepareStatementForSqlObject($sqlSelect);
        $adapter   = $this->tableGateway->getAdapter();

        $sqlString = $sql->getSqlStringForSqlObject($sqlSelect, $this->getPlatform());

        $statement->setSql($sqlString);

        try {

            $result = $statement->execute($parameters);

        } catch (\Exception $e) {

            throw new Exception\RuntimeException(
                    sprintf(
                        'Statement could not be executed %s',
                        $sqlString
                    ) . '; ' . $e->getPrevious()->getMessage(),
                    $e->getCode(),
                    $e
            );
        }

        $rows = new \ArrayObject;

        foreach ($result as $row) {
            $rows[$row['id']] = $row;
        }

        $dataEvent->setParam('rows', $rows);

        $events->trigger(DataEvent::EVENT_FETCH_POST, $dataEvent);

        return $rows->getArrayCopy();
    }

    /**
     * Delete
     *
     * @param  Where|\Closure|string|array $where
     * @return int
     */
    public function delete($where)
    {
        // todo event

        return $this->tableGateway->delete($where);
    }

    public function fetchJust($selectName, $term, array $parameters = array())
    {
        $select = $this->configSelect($selectName);
        $select->where($this->search($term, $this->config['searchIn'], 'AND'));

        return $this->fetchWith($select, $parameters);
    }

    public function fetchLike($selectName, $term, array $parameters = array())
    {
        $select = $this->configSelect($selectName);
        $select->where($this->search($term, $this->config['searchIn'], 'OR'));

        return $this->fetchWith($select, $parameters);
    }

    public function own(&$subject, $id)
    {
        $subject[$this->key()] = $id;
        return $subject;
    }

    public function owned($service, $id)
    {
        $column = $service->getTableName() . '_id=?';
        $where  = array($column => $id);

        return $this->tableGateway->fetch($where)->toArray();
    }

    public function validate(array $data)
    {
        /* @var $inputFilter \Zend\InputFilter\InputFilter */
        $inputFilter = $this->getInputFilter();
        $inputFilter->setData($data);

        if (!$inputFilter->isValid()) {
            throw new Exception\RuntimeException(
                sprintf('Expected valid data: %s', print_r($inputFilter->getMessages(), 1))
            );
        }
        return $inputFilter->getValues();
    }

    public function getArrayCopy()
    {
        return array();
    }

    public function exchangeArray(array $data)
    {
        $this->init();

        $events    = $this->getEventManager();
        $dataEvent = $this->getEvent();

        $dataObject = new \ArrayObject($data);
        $dataEvent->setParam('service', $this);
        $dataEvent->setParam('data', $dataObject);

        $events->trigger(DataEvent::EVENT_EXCHANGE_PRE, $dataEvent);

//        $validData['datetime_update'] = date('Y-m-d H:i:s');
        $validData = $this->validate($dataObject->getArrayCopy());

        $dataExchange         = array_flip(array_keys($validData));
        $filterExchange       = array_flip(array_keys($this->config['input_filter']));
        $filterExchange['id'] = true;

        array_filter(
            array_keys($validData),
            function ($key) use (&$validData, $dataExchange, $filterExchange) {

                if (!isset($dataExchange[$key])) {
                    unset($data[$key]);
                }
                if (!isset($filterExchange[$key])) {
                    unset($data[$key]);
                }
            }
        );

        try {

            if (empty($validData['id'])) {

                $this->tableGateway->insert($validData);

            } else {

                $this->tableGateway->update($validData, array('id=?' => $validData['id']));
            }

        } catch (\Exception $e) {

            throw new Exception\RuntimeException(
                    sprintf(
                        'Statement could not be executed'
                    ) . '; ' . $e->getPrevious()->getMessage(),
                    $e->getCode(),
                    $e
            );
        }

        $events->trigger(DataEvent::EVENT_EXCHANGE_POST, $dataEvent);
    }

    public function executeQuery($query)
    {
        return $this->tableGateway
                    ->getAdapter()
                    ->query($query)
                    ->execute();
    }

    public function toggle($column, array $where)
    {
        $query = $this->getQuery()
                      ->toggle($column)
                      ->where($where);

        return $this->executeQuery($query->toString());
    }

    public function increment($column, array $where)
    {
        $query = $this->getQuery()
                      ->increment($column)
                      ->where($where);

        return $this->executeQuery($query->toString());
    }

    public function decrement($column, array $where)
    {
        $query = $this->getQuery()
                      ->decrement($column)
                      ->where($where);

        return $this->executeQuery($query->toString());
    }

    protected function getAdapter()
    {
        return $this->tableGateway->getAdapter();
    }

    protected function configureSelect(Sql\Select $select, array $config)
    {
        if (isset($config['columns'])) {

            array_key_exists(1, $config['columns']) or
                $config['columns'][1] = false;

            $select->columns($config['columns'][0], $config['columns'][1]);
        }

        if (isset($config['where'])) {

            array_key_exists(1, $config['where']) or
                $config['where'][1] = Sql\Predicate\PredicateSet::OP_AND;

            $select->where($config['where'][0], $config['where'][1]);
        }

        empty($config['order']) or
            $select->order($config['order']);

        empty($config['limit']) or
            $select->limit($config['limit']);

        empty($config['offset']) or
            $select->offset($config['offset']);
    }

    protected function key($postfix = '', $idPostfix = '_id')
    {
        return $this->getTableName() . $idPostfix . $postfix;
    }

    protected function search($term, array $columns, $type = 'AND')
    {
        $term     = preg_replace('~[^a-zA-Z0-9]+~', ' ', $term);
        $platform = $this->getPlatform();
        $where    = array();

        foreach (explode(' ', $term) as $word) {

            if (empty($word)) {
                continue;
            }

            foreach ($columns as $col) {

                $word    = preg_replace('~[^a-zA-Z0-9]+~', '%', $word);
                $where[] = $platform->quoteIdentifier($col) . ' LIKE '
                         . $platform->quoteValue('%' . $word . '%');
            }
        }

        return '(' . join(' ' . $type . ' ', $where) . ')';
    }
}
