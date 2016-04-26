<?php

namespace WebinoData;

use ArrayObject;
use WebinoData\DataSelect;
use WebinoData\Event\DataEvent;
use WebinoData\Exception;
use WebinoData\InputFilter\InputFilter;
use WebinoData\InputFilter\InputFilterFactoryAwareInterface;
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

/**
 * Class AbstractDataService
 * @todo refactor/redesign
 */
abstract class AbstractDataService implements
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
    protected $config = [];

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
    protected $subServices = [];

    /**
     * @var bool
     */
    protected $initialized = false;


    //todo
    protected $query;

    protected $hasOneList = [];
    protected $hasManyList = [];

    protected $hasOneService = [];
    protected $hasManyService = [];

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
     * @return array
     */
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

        empty($this->config['plugin'])
            or $this->initPlugin($this->config['plugin']);
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

        $attachedPlugins = [];
        foreach ($config as $pluginKey => $pluginName) {

            // resolve plugin settings
            $pluginOptions = [];
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

            // do not attach the same plugin more than once
            if (isset($attachedPlugins[$pluginName])) {
                continue;
            }
            $attachedPlugins[$pluginName] = true;

            // attach plugin
            $plugin = clone $serviceManager->get($pluginName);
            $plugin->attach($eventManager);

            empty($pluginOptions)
                or $plugin->setOptions($pluginOptions);
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
        (null === $this->event) and $this->createEvent();
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
     * @return DataService
     */
    protected function createEvent()
    {
        $event = new DataEvent;
        $event->setService($this);
        $this->setEvent($event);
        return $event;
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
            [
                __CLASS__,
                'WebinoData',
                'WebinoData[' . $this->getTableName() . ']',
                // todo deprecated
                $this->getTableName()
            ]
        );

        $this->eventManager = $eventManager;
        return $this;
    }

    /**
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
     * @param string $name
     * @param DataService $service
     * @param array $options
     * @return DataService
     */
    public function setHasOne($name, DataService $service, array $options = [])
    {
        isset($this->hasOneList[$name])
            or $this->hasOneList[$name] = [];

        $this->hasOneList[$name]['service'] = $service;
        $this->hasOneList[$name]['options'] = $options;
        return $this;
    }

    /**
     * @param string $name
     * @param string $serviceName
     * @param array $options
     * @return DataService
     */
    public function setHasOneService($name, $serviceName, array $options = [])
    {
        if (empty($name)) {
            // TODO exception
            throw new \InvalidArgumentException('Name cannot be null');
        }

        isset($this->hasOneService[$name])
            or $this->hasOneService[$name] = [];

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
                // TODO exception
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

                empty($item['service'])
                    and $item = $this->resolveOne($name);

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
     * @param array $options
     * @return DataService
     */
    public function setHasMany($name, DataService $service, array $options = [])
    {
        isset($this->hasManyList[$name])
            or $this->hasManyList[$name] = [];

        $this->hasManyList[$name]['service'] = $service;
        $this->hasManyList[$name]['options'] = $options;
        return $this;
    }

    /**
     * @param string $name
     * @param string $serviceName
     * @param array $options
     * @return DataService
     */
    public function setHasManyService($name, $serviceName, array $options = [])
    {
        if (empty($name)) {
            // TODO exception
            throw new \InvalidArgumentException('Name cannot be null');
        }

        isset($this->hasManyService[$name])
            or $this->hasManyService[$name] = [];

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
                // TODO exception
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

                empty($item['service'])
                    and $item = $this->resolveMany($name);

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

    /**
     * @return Sql\Sql
     */
    public function getSql()
    {
        return $this->tableGateway->getSql();
    }

    /**
     * @todo
     * @return DataQuery
     */
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

    /**
     * @param DataQuery $query
     * @return $this
     */
    public function setQuery(DataQuery $query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @param array $columns
     * @return DataSelect
     */
    public function select($columns = [])
    {
        $this->init();

        $select = new DataSelect($this, $this->getSql()->select());

        empty($columns) or $select->columns($columns, false);

        $events = $this->getEventManager();
        $event  = $this->createEvent();

        $event->setSelect($select);
        $events->trigger(DataEvent::EVENT_SELECT, $event);

        return $select;
    }

    /**
     * @param string $name
     * @return DataSelect
     */
    public function configSelectset($name)
    {
        $select = $this->select();
        if (empty($this->config['selectset'][$name])) {
            return $select;
        }

        return $this->configSelect($this->config['selectset'][$name]);
    }

    /**
     * @return DataSelect
     */
    public function configSelect()
    {
        $firstArg    = func_get_arg(0);
        $selectNames = is_array($firstArg) ? $firstArg : func_get_args();
        $select      = $this->select();

        $selectConfig = [];
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

    /**
     * @param $selectName
     * @param array $parameters
     * @return array|ArrayObject
     */
    public function fetch($selectName, $parameters = [])
    {
        return $this->fetchWith($this->configSelect($selectName), $parameters);
    }

    /**
     * @param DataSelect $select
     * @param array $parameters
     * @return ArrayObject|array
     */
    public function fetchWith(DataSelect $select, $parameters = [])
    {
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event->setSelect($select);
        $events->trigger(DataEvent::EVENT_FETCH_PRE, $event);

        $rows = new ArrayObject;
        foreach ($select->execute($this->getSql(), $parameters) as $row) {

            if (empty($row['id'])) {
                $rows[] = $row;
            } elseif (empty($rows[$row['id']])) {
                $rows[$row['id']] = $row;
            } else {
                $rows[$row['id'] . '/' . count($rows)] = $row;
            }
        }

        $event->setRows($rows);
        $events->trigger(DataEvent::EVENT_FETCH_POST, $event);
        return $event->getRows();
    }

    /**
     * @param DataSelect $select
     * @param array $parameters
     * @return array
     */
    public function fetchPairs(DataSelect $select, $parameters = [])
    {
        $data = [];
        foreach ($this->fetchWith($select, $parameters) as $row) {
            $data[current($row)] = next($row);
        }
        return $data;
    }

    /**
     * @param $callback
     * @param DataSelect|null $select
     * @return $this
     */
    public function export($callback, DataSelect $select = null)
    {
        if (!is_callable($callback)) {
            // TODO exception
            throw new \InvalidArgumentException('Provided `$callback` not callable');
        }

        $this->init();

        $select = empty($select) ? $this->select() : $select;
        $result = $this->fetchWith($select);
        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event->setResult($result);

        foreach ($result as $row) {
            $rowObject = new ArrayObject($row);

            $event
                ->setRow($rowObject)
                ->setParam('callback', $callback);

            $events->trigger(DataEvent::EVENT_EXPORT, $event);
            $rowObject->count() and $callback($rowObject->getArrayCopy());
        }

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->init();

        $dataObject = new ArrayObject($data);

        $events = $this->getEventManager();
        $event  = clone $this->getEvent();

        $event->setData($dataObject);
        $events->trigger(DataEvent::EVENT_IMPORT, $event);

        $dataObject->count()
            and $this->exchangeArray($dataObject->getArrayCopy());

        return $this;
    }

    /**
     * @param Sql\Where|\Closure|string|array $where
     * @return int
     */
    public function delete($where)
    {
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event->setArguments([$where]);
        $events->trigger(DataEvent::EVENT_DELETE, $event);

        if ($event->propagationIsStopped()) {
            return 0;
        }

        $affectedRows = $this->tableGateway->delete($where);
        $event->setAffectedRows($affectedRows);
        $events->trigger(DataEvent::EVENT_DELETE_POST, $event);
        return $affectedRows;
    }

    /**
     * @param array $subject
     * @param int $id
     * @return mixed
     */
    public function own(&$subject, $id)
    {
        $subject[$this->key()] = $id;
        return $subject;
    }

    /**
     * @param self $service
     * @param int $id
     * @return mixed
     */
    public function owned($service, $id)
    {
        $column = $service->getTableName() . '_id=?';
        $where  = [$column => $id];

        return $this->tableGateway->fetch($where)->toArray();
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return [];
    }

    /**
     * @param array $array
     * @return int Affected rows
     */
    public function exchangeArray(array $array)
    {
        if (empty($array)) {
            // TODO exception
            throw new \InvalidArgumentException('Expected data but empty');
        }

        $this->init();

        $event = $this->getEvent();
        $event->setUpdate(!empty($array['id']));

        // update where
        $updateWhere = null;
        if ($event->isUpdate()) {
            if ($array['id'] instanceof DataSelect) {
                $updateWhere = [new Sql\Predicate\In('id', $array['id']->getSqlSelect())];
                unset($array['id']);

            } elseif (is_array($array['id'])
                || $array['id'] instanceof Sql\Where
                || $array['id'] instanceof \Closure
            ) {
                $updateWhere = $array['id'];
                unset($array['id']);

            } else {
                $updateWhere = ['id=?' => $array['id']];
            }
        }
        $event->setParam('updateWhere', $updateWhere);
        // /update where

        $data = new ArrayObject($array);

        $event->setData($data);
        $inputFilter = $this->getInputFilter();

        $this->filterInputFilter($array, $inputFilter, $event->isUpdate());

        $inputFilter->getValidInput()
            or $inputFilter->validate($data->getArrayCopy());

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
        $isEmpty = empty($validDataArray);

        $affectedRows = 0;
        if (!$isEmpty) {
            $this->filterNonexistentNullValues($array, $validDataArray);

            try {
                $affectedRows = $event->isUpdate()
                              ? $this->tableGateway->update($validDataArray, $updateWhere)
                              : $this->tableGateway->insert($validDataArray);

            } catch (\Exception $exc) {
                throw new Exception\RuntimeException(
                        sprintf(
                            'Statement could not be executed for the service table `%s`',
                            $this->getTableName()
                        ) . '; ' . ($exc->getPrevious() ? $exc->getPrevious()->getMessage() : $exc->getMessage()),
                        $exc->getCode(),
                        $exc
                );
            }
        }

        // make sure we have an id
        isset($data['id']) && is_numeric($data['id'])
            or $data['id'] = $this->tableGateway->getLastInsertValue();

        // reset input filter
        $this->inputFilter = null;

        // trigger event
        $event->setAffectedRows($affectedRows);
        $isEmpty or $events->trigger(DataEvent::EVENT_EXCHANGE_POST, $event);

        return $event->getAffectedRows();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function executeQuery($query)
    {
        return $this->tableGateway
                    ->getAdapter()
                    ->query($query)
                    ->execute();
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
        $events->trigger(DataEvent::EVENT_TOGGLE, $event);

        $query = $this->getQuery()
                      ->toggle($column)
                      ->where($where);

        $result = $this->executeQuery($query->toString());
        $event->setAffectedRows($result->getAffectedRows());
        $events->trigger(DataEvent::EVENT_TOGGLE_POST, $event);
        return $result;
    }

    /**
     * @param string $column
     * @param mixed $where
     * @return mixed
     */
    public function increment($column, $where)
    {
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event->setArguments([$column, $where]);
        $events->trigger(DataEvent::EVENT_INCREMENT, $event);

        $query = $this->getQuery()
                      ->increment($column)
                      ->where($where);

        $result = $this->executeQuery($query->toString());
        $event->setAffectedRows($result->getAffectedRows());
        $events->trigger(DataEvent::EVENT_INCREMENT_POST, $event);
        return $result;
    }

    /**
     * @param string $column
     * @param mixed $where
     * @return mixed
     */
    public function decrement($column, $where)
    {
        $this->init();

        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event->setArguments([$column, $where]);
        $events->trigger(DataEvent::EVENT_DECREMENT, $event);

        $query = $this->getQuery()
                      ->decrement($column)
                      ->where($where);

        $result = $this->executeQuery($query->toString());
        $event->setAffectedRows($result->getAffectedRows());
        $events->trigger(DataEvent::EVENT_DECREMENT_POST, $event);
        return $result;
    }

    /**
     * @return \Zend\Db\Adapter\AdapterInterface
     */
    public function getAdapter()
    {
        return $this->tableGateway->getAdapter();
    }

    /**
     * @param string $postfix
     * @param string $idPostfix
     * @return string
     */
    protected function key($postfix = '', $idPostfix = '_id')
    {
        return $this->getTableName() . $idPostfix . $postfix;
    }

    /**
     * @param $term
     * @param array $columns
     * @param string $type
     * @return string
     */
    protected function search($term, array $columns, $type = 'AND')
    {
        $term     = preg_replace('~[^a-zA-Z0-9]+~', ' ', $term);
        $platform = $this->getPlatform();
        $where    = [];

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

    /**
     * Remove null values that are no required
     *
     * @param array $data
     * @param array &$validData
     * @return $this
     */
    private function filterNonexistentNullValues(array $data, array &$validData)
    {
        foreach ($validData as $key => $value) {
            if (null === $value && 'id' !== $key && !array_key_exists($key, $data)) {
                unset($validData[$key]);
            }
        }

        return $this;
    }

    /**
     * Filter inputs by data
     *
     * @param array $data
     * @param InputFilter $inputFilter
     * @param bool $isUpdate
     * @return $this
     */
    public function filterInputFilter(array $data, InputFilter $inputFilter, $isUpdate)
    {
        if (!$isUpdate) {
            return $this;
        }

        foreach ($inputFilter->getInputs() as $input) {
            $inputName = $input->getName();

            array_key_exists($inputName, $data)
                or $inputFilter->remove($inputName);
        }

        return $this;
    }

    public function __clone()
    {
        $this->event and $this->event = clone $this->event;
        $this->inputFilter and $this->inputFilter = clone $this->inputFilter;
    }
}
