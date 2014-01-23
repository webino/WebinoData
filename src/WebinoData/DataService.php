<?php

namespace WebinoData;

use ArrayObject;
use WebinoData\InputFilter\InputFilter;
use WebinoData\InputFilter\InputFilterFactoryAwareInterface;
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

// todo refactor
class DataService implements
    EventManagerAwareInterface,
    ServiceManagerAwareInterface,
    InputFilterFactoryAwareInterface
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

    protected $hasOneService = array();
    protected $hasManyService = array();


    /**
     * @param TableGateway $tableGateway
     * @param array $config
     */
    public function __construct(TableGateway $tableGateway, array $config)
    {
        $this->tableGateway = $tableGateway;
        $this->config       = $config;
    }

    public function getConfig()
    {
        return $this->config;
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

        foreach ($config as $pluginKey => $pluginName) {

            $pluginOptions = array();
            if (is_array($pluginName)) {

                if (!empty($pluginName['plugin'])) {
                    $pluginName = $pluginName['plugin'];
                    unset($pluginName['plugin']);
                    $pluginOptions = $pluginName;

                } else {
                    $pluginOptions = $pluginName;
                    $pluginName    = $pluginKey;
                }
            }

            $plugin = $serviceManager->get($pluginName);
            $plugin->attach($eventManager);

            empty($pluginOptions) or
                $plugin->setOptions($pluginOptions);
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
        if (!method_exists($inputFilter, 'validate')) {
            // todo: interface
            throw new \InvalidArgumentException(
                'Expects inputFilter validate() method for: ' . $this->getTableName()
            );
        }
        $this->inputFilter = $inputFilter;
        return $this;
    }

    /**
     * @deprecated Use setHasManyService instead, it prevents circular dependency exception
     * @param DataService $service
     * @return DataService
     */
    public function setHasOne($name, DataService $service, array $options = array())
    {
        isset($this->hasOneList[$name]) or
            $this->hasOneList[$name] = array();

        $this->hasOneList[$name]['service'] = $service;
        $this->hasOneList[$name]['options'] = $options;
        return $this;
    }

    /**
     * @param DataService $service
     * @return DataService
     */
    public function setHasOneService($name, $serviceName, array $options = array())
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Name cannot be null');
        }

        isset($this->hasOneService[$name]) or
            $this->hasOneService[$name] = array();

        $this->hasOneService[$name]['serviceName'] = $serviceName;
        $this->hasOneService[$name]['options']     = $options;
        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasOne($name)
    {
        if (!empty($this->hasOneList[$name])) {
            return true;
        }
        return !empty($this->hasOneService[$name]);
    }

    /**
     * @param string $name
     * @return DataService
     * @throws \OutOfBoundsException
     */
    protected function resolveOne($name)
    {
        if (empty($this->hasOneList[$name])) {
            if (empty($this->hasOneService[$name])) {
                throw new \OutOfBoundsException('Hasn\'t one ' . $name . '; ' . $this->getTableName());
            } else {
                $serviceName = $this->hasOneService[$name]['serviceName'];
                $this->hasOneService[$name]['service'] = $this->serviceManager->get($serviceName);
                return $this->hasOneService[$name];
            }
        }

        return $this->hasOneList[$name];
    }
    /**
     * @param string $name
     * @return DataService
     */
    public function one($name)
    {
        $item = $this->resolveOne($name);
        return $item['service'];
    }

    /**
     * @param string $name
     * @return DataService
     */
    public function oneOptions($name)
    {
        $item = $this->resolveOne($name);
        return $item['options'];
    }

    /**
     * @return array
     */
    public function getHasOneList()
    {
        $hasOne = $this->hasOneList;
        if (!empty($this->hasOneService)) {
            foreach ($this->hasOneService as $name => $item) {

                !empty($item['service']) or
                    $item = $this->resolveOne($name);

                $hasOne[$name] = $item;
            }
        }

        return $hasOne;
    }

    /**
     * @return array
     */
    public function getHasOneService()
    {
        return $this->hasOneService;
    }

    /**
     * @deprecated Use setHasManyService instead, it prevents circular dependency exception
     * @param string $name
     * @param DataService $service
     * @return DataService
     */
    public function setHasMany($name, DataService $service, array $options = array())
    {
        isset($this->hasManyList[$name]) or
            $this->hasManyList[$name] = array();

        $this->hasManyList[$name]['service'] = $service;
        $this->hasManyList[$name]['options'] = $options;
        return $this;
    }

    /**
     * @param string $name
     * @param string $serviceName
     * @return DataService
     */
    public function setHasManyService($name, $serviceName, array $options = array())
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Name cannot be null');
        }

        isset($this->hasManyService[$name]) or
            $this->hasManyService[$name] = array();

        $this->hasManyService[$name]['serviceName'] = $serviceName;
        $this->hasManyService[$name]['options']     = $options;
        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasMany($name)
    {
        if (!empty($this->hasManyList[$name])) {
            return true;
        }
        return !empty($this->hasManyService[$name]);
    }

    /**
     * @param string $name
     * @return DataService
     * @throws \OutOfBoundsException
     */
    protected function resolveMany($name)
    {
        if (empty($this->hasManyList[$name])) {
            if (empty($this->hasManyService[$name])) {
                throw new \OutOfBoundsException('Hasn\'t many ' . $name . '; ' . $this->getTableName());
            } else {
                $serviceName = $this->hasManyService[$name]['serviceName'];
                $this->hasManyService[$name]['service'] = $this->serviceManager->get($serviceName);
                return $this->hasManyService[$name];
            }
        }

        return $this->hasManyList[$name];
    }

    /**
     * @param string $name
     * @return DataService
     */
    public function many($name)
    {
        $item = $this->resolveMany($name);
        return $item['service'];
    }

    /**
     * @param string $name
     * @return DataService
     */
    public function manyOptions($name)
    {
        $item = $this->resolveMany($name);
        return $item['options'];
    }

    /**
     * @return array
     */
    public function getHasManyList()
    {
        $hasMany = $this->hasManyList;
        if (!empty($this->hasManyService)) {
            foreach ($this->hasManyService as $name => $item) {

                !empty($item['service']) or
                    $item = $this->resolveMany($name);

                $hasMany[$name] = $item;
            }
        }

        return $hasMany;
    }

    /**
     * @return array
     */
    public function getHasManyService()
    {
        return $this->hasManyList;
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

    public function getSql()
    {
        return $this->tableGateway->getSql();
    }

    // todo
    public function getQuery()
    {
        if (null === $this->query) {
            $this->setQuery(
                new DataQuery(
                    $this->getSql(),
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

    public function select($columns = array())
    {
        $this->init();

        $select = new \WebinoData\DataSelect(
            $this,
            $this->getSql()->select()
        );

        empty($columns) or
            $select->columns($columns, false);

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event->setService($this);
        $event->setSelect($select);

        $events->trigger(DataEvent::EVENT_SELECT, $event);

        return $select;
    }

    public function configSelect()
    {
        $firstArg    = func_get_arg(0);
        $selectNames = is_array($firstArg) ? $firstArg : func_get_args();
        $select      = $this->select();

        $selectConfig = array();
        foreach ($selectNames as $selectName) {

            if (!is_string($selectName)) {
                continue;
            }
            if (!isset($this->config['select'][$selectName])) {
                // allow empty select config
                continue;
            }

            $selectConfig = array_replace_recursive($selectConfig, $this->config['select'][$selectName]);
        }

        $select->configure($selectConfig);

        return $select;
    }

    public function fetch($selectName, $parameters = array())
    {
        return $this->fetchWith($this->configSelect($selectName), $parameters);
    }

    public function fetchWith(\WebinoData\DataSelect $select, $parameters = array())
    {
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event
            ->setService($this)
            ->setSelect($select);

        $events->trigger(DataEvent::EVENT_FETCH_PRE, $event);

        $sqlSelect = $select->getSqlSelect();
        $sql       = $this->getSql();
        $statement = $sql->prepareStatementForSqlObject($sqlSelect);

        try {
            $result = $statement->execute($parameters);

        } catch (\Exception $e) {

            throw new Exception\RuntimeException(
                    sprintf(
                        'Statement could not be executed %s',
                        $sql->getSqlStringForSqlObject($sqlSelect, $this->getPlatform())
                    ) . '; ' . $e->getPrevious()->getMessage(),
                    $e->getCode(),
                    $e
            );
        }

        $rows = new ArrayObject;

        foreach ($result as $row) {

            if (!empty($row['id'])
                && empty($rows[$row['id']])
            ) {
                $rows[$row['id']] = $row;
            } else {
                $rows[] = $row;
            }
        }

        $event->setRows($rows);

        $events->trigger(DataEvent::EVENT_FETCH_POST, $event);

        return $event->getRows();
    }

    public function fetchPairs(\WebinoData\DataSelect $select, $parameters = array())
    {
        $data = array();
        foreach ($this->fetchWith($select, $parameters) as $row) {
            $data[current($row)] = next($row);
        }
        return $data;
    }

    public function export($callback, DataSelect $select = null)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('Provided `$callback` not callable');
        }

        $select = empty($select) ? $this->select() : $select;
        $result = $this->executeQuery((string) $select);

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event
            ->setService($this)
            ->setResult($result);

        foreach ($result as $row) {

            $rowObject = new ArrayObject($row);

            $event
                ->setRow($rowObject)
                ->setParam('callback', $callback);

            $events->trigger(DataEvent::EVENT_EXPORT, $event);

            !$rowObject->count() or
                $callback($rowObject->getArrayCopy());
        }

        return $this;
    }

    public function import(array $data)
    {
        $dataObject = new ArrayObject($data);

        $events = $this->getEventManager();
        $event  = clone $this->getEvent();

        $event
            ->setService($this)
            ->setData($dataObject);

        $events->trigger(DataEvent::EVENT_IMPORT, $event);

        !$dataObject->count() or
            $this->exchangeArray($dataObject->getArrayCopy());

        return $this;
    }

    /**
     * Delete
     *
     * @param  Where|\Closure|string|array $where
     * @return int
     */
    public function delete($where)
    {
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event
            ->setService($this)
            ->setArguments(array($where));

        $events->trigger(DataEvent::EVENT_DELETE, $event);

        if ($event->propagationIsStopped()) {
            return 0;
        }

        $result = $this->tableGateway->delete($where);

        $events->trigger(DataEvent::EVENT_DELETE_POST, $event);

        return $result;
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

    public function getArrayCopy()
    {
        return array();
    }

    public function exchangeArray(array $array)
    {
        if (empty($array)) {
            throw new \InvalidArgumentException('Expected data but empty');
        }

        $this->init();

        $event = $this->getEvent();
        $event->setUpdate(!empty($array['id']));

        // update where
        if ($event->isUpdate()) {

            if ($array['id'] instanceof DataSelect) {

                $updateWhere = array(new Sql\Predicate\In('id', $array['id']->getSqlSelect()));
                unset($array['id']);

            } elseif (is_array($array['id'])
                || $array['id'] instanceof Sql\Where
                || $array['id'] instanceof \Closure
            ) {
                $updateWhere = $array['id'];
                unset($array['id']);

            } else {
                $updateWhere = array('id=?' => $array['id']);
            }
        }
        // /update where

        $data = new ArrayObject($array);

        $event
            ->setService($this)
            ->setData($data);

        $inputFilter = $this->getInputFilter();

        // on update filter by exchange
        !$event->isUpdate() or
            $this->filterInputFilter($array, $inputFilter);

        $inputFilter->getValidInput() or
            $inputFilter->validate($data->getArrayCopy());

        $events = $this->getEventManager();

        if ($inputFilter->getInvalidInput()) {

            $events->trigger(DataEvent::EVENT_EXCHANGE_INVALID, $event);

            // post invalid validation
            if (!$inputFilter->validate($data->getArrayCopy())) {

                // reset input filter
                $this->inputFilter = null;

                throw new Exception\RuntimeException(
                    sprintf(
                        'Expected valid data: %s %s',
                        print_r($inputFilter->getMessages(), true),
                        print_r($data, true)
                    )
                );
            }
        }

        $validData = new ArrayObject($inputFilter->getValues());
        $event->setValidData($validData);

        $events->trigger(DataEvent::EVENT_EXCHANGE_PRE, $event);
        $validDataArray = $validData->getArrayCopy();

        try {
            if ($event->isUpdate()) {
                $this->tableGateway->update($validDataArray, $updateWhere);
            } else {
                $this->tableGateway->insert($validDataArray);
            }
        } catch (\Exception $e) {

            throw new Exception\RuntimeException(
                    sprintf(
                        'Statement could not be executed for the service table `%s`',
                        $this->getTableName()
                    ) . '; ' . $e->getPrevious()->getMessage(),
                    $e->getCode(),
                    $e
            );
        }

        // reset input filter
        $this->inputFilter = null;

        $events->trigger(DataEvent::EVENT_EXCHANGE_POST, $event);

        return $this;
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
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event
            ->setService($this)
            ->setArguments(array($column, $where));

        $events->trigger(DataEvent::EVENT_TOGGLE, $event);

        $query = $this->getQuery()
                      ->toggle($column)
                      ->where($where);

        return $this->executeQuery($query->toString());
    }

    public function increment($column, array $where)
    {
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event
            ->setService($this)
            ->setArguments(array($column, $where));

        $events->trigger(DataEvent::EVENT_INCREMENT, $event);

        $query = $this->getQuery()
                      ->increment($column)
                      ->where($where);

        return $this->executeQuery($query->toString());
    }

    public function decrement($column, array $where)
    {
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event
            ->setService($this)
            ->setArguments(array($column, $where));

        $events->trigger(DataEvent::EVENT_DECREMENT, $event);

        $query = $this->getQuery()
                      ->decrement($column)
                      ->where($where);

        return $this->executeQuery($query->toString());
    }

    public function getAdapter()
    {
        return $this->tableGateway->getAdapter();
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

    protected function filterInputFilter(array $data, InputFilter $inputFilter)
    {
        $exchange = array_flip(array_keys($data));
        foreach ($inputFilter->getInputs() as $input) {

            $inputName = $input->getName();

            isset($exchange[$inputName]) or
                $inputFilter->remove($inputName);
        }

        return $this;
    }
}
