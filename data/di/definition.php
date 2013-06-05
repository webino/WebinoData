<?php 
return array (
  'WebinoData\\Module' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoData\\DataEvent' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventInterface',
      1 => 'Zend\\EventManager\\Event',
      2 => 'Zend\\EventManager\\EventInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => true,
      'setParams' => false,
      'setName' => false,
      'setTarget' => false,
      'setParam' => false,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\DataEvent::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\DataEvent::__construct:1' => 
        array (
          0 => 'target',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\DataEvent::__construct:2' => 
        array (
          0 => 'params',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setParams' => 
      array (
        'WebinoData\\DataEvent::setParams:0' => 
        array (
          0 => 'params',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setName' => 
      array (
        'WebinoData\\DataEvent::setName:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setTarget' => 
      array (
        'WebinoData\\DataEvent::setTarget:0' => 
        array (
          0 => 'target',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setParam' => 
      array (
        'WebinoData\\DataEvent::setParam:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataEvent::setParam:1' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Paginator\\Adapter\\WebinoDataSelect' => 
  array (
    'supertypes' => 
    array (
      0 => 'Countable',
      1 => 'Zend\\Paginator\\Adapter\\AdapterInterface',
      2 => 'Zend\\Paginator\\Adapter\\DbSelect',
      3 => 'Zend\\Paginator\\Adapter\\AdapterInterface',
      4 => 'Countable',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => true,
      'setOverflow' => false,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Paginator\\Adapter\\WebinoDataSelect::__construct:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\DataSelect',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Paginator\\Adapter\\WebinoDataSelect::__construct:1' => 
        array (
          0 => 'service',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setOverflow' => 
      array (
        'WebinoData\\Paginator\\Adapter\\WebinoDataSelect::setOverflow:0' => 
        array (
          0 => 'overflow',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Exception\\ExceptionInterface' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoData\\Exception\\InvalidArgumentException' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Exception\\ExceptionInterface',
      1 => 'InvalidArgumentException',
      2 => 'LogicException',
      3 => 'Exception',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => true,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Exception\\InvalidArgumentException::__construct:0' => 
        array (
          0 => 'message',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\Exception\\InvalidArgumentException::__construct:1' => 
        array (
          0 => 'code',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\Exception\\InvalidArgumentException::__construct:2' => 
        array (
          0 => 'previous',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Exception\\MissingPropertyException' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Exception\\ExceptionInterface',
      1 => 'InvalidArgumentException',
      2 => 'LogicException',
      3 => 'Exception',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => true,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Exception\\MissingPropertyException::__construct:0' => 
        array (
          0 => 'message',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\Exception\\MissingPropertyException::__construct:1' => 
        array (
          0 => 'code',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\Exception\\MissingPropertyException::__construct:2' => 
        array (
          0 => 'previous',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Exception\\RuntimeException' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Exception\\ExceptionInterface',
      1 => 'RuntimeException',
      2 => 'Exception',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => true,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Exception\\RuntimeException::__construct:0' => 
        array (
          0 => 'message',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\Exception\\RuntimeException::__construct:1' => 
        array (
          0 => 'code',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\Exception\\RuntimeException::__construct:2' => 
        array (
          0 => 'previous',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\DataService' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventManagerAwareInterface',
      1 => 'Zend\\EventManager\\EventsCapableInterface',
      2 => 'Zend\\ServiceManager\\ServiceManagerAwareInterface',
      3 => 'WebinoData\\InputFilter\\InputFilterFactoryAwareInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => true,
      'setEvent' => false,
      'setEventManager' => true,
      'setServiceManager' => true,
      'setPlatform' => false,
      'setInputFilterFactory' => true,
      'setInputFilter' => false,
      'setHasOne' => false,
      'setHasMany' => false,
      'setQuery' => false,
      'getEventManager' => true,
      'getInputFilter' => true,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\DataService::__construct:0' => 
        array (
          0 => 'tableGateway',
          1 => 'Zend\\Db\\TableGateway\\TableGateway',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataService::__construct:1' => 
        array (
          0 => 'config',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoData\\DataService::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoData\\DataEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoData\\DataService::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setServiceManager' => 
      array (
        'WebinoData\\DataService::setServiceManager:0' => 
        array (
          0 => 'serviceManager',
          1 => 'Zend\\ServiceManager\\ServiceManager',
          2 => true,
          3 => NULL,
        ),
      ),
      'setPlatform' => 
      array (
        'WebinoData\\DataService::setPlatform:0' => 
        array (
          0 => 'platform',
          1 => 'Zend\\Db\\Adapter\\Platform\\PlatformInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setInputFilterFactory' => 
      array (
        'WebinoData\\DataService::setInputFilterFactory:0' => 
        array (
          0 => 'inputFilter',
          1 => 'Zend\\InputFilter\\Factory',
          2 => true,
          3 => NULL,
        ),
      ),
      'setInputFilter' => 
      array (
        'WebinoData\\DataService::setInputFilter:0' => 
        array (
          0 => 'inputFilter',
          1 => 'Zend\\InputFilter\\InputFilterInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setHasOne' => 
      array (
        'WebinoData\\DataService::setHasOne:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataService::setHasOne:1' => 
        array (
          0 => 'service',
          1 => 'WebinoData\\DataService',
          2 => true,
          3 => NULL,
        ),
      ),
      'setHasMany' => 
      array (
        'WebinoData\\DataService::setHasMany:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataService::setHasMany:1' => 
        array (
          0 => 'service',
          1 => 'WebinoData\\DataService',
          2 => true,
          3 => NULL,
        ),
      ),
      'setQuery' => 
      array (
        'WebinoData\\DataService::setQuery:0' => 
        array (
          0 => 'query',
          1 => 'WebinoData\\DataQuery',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\DataQuery' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => true,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\DataQuery::__construct:0' => 
        array (
          0 => 'sql',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataQuery::__construct:1' => 
        array (
          0 => 'platform',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\DataSelect' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => true,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\DataSelect::__construct:0' => 
        array (
          0 => 'service',
          1 => 'WebinoData\\DataService',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataSelect::__construct:1' => 
        array (
          0 => 'sqlSelect',
          1 => 'Zend\\Db\\Sql\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\InputFilter\\InputFilterFactoryAwareInterface' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setInputFilterFactory' => false,
    ),
    'parameters' => 
    array (
      'setInputFilterFactory' => 
      array (
        'WebinoData\\InputFilter\\InputFilterFactoryAwareInterface::setInputFilterFactory:0' => 
        array (
          0 => 'inputFilter',
          1 => 'Zend\\InputFilter\\Factory',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\DataPlugin\\Relations' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => true,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\DataPlugin\\Relations::__construct:0' => 
        array (
          0 => 'adapter',
          1 => 'Zend\\Db\\Adapter\\AdapterInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\DataQuery\\Decrement' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\DataQuery\\Toggle',
      1 => 'WebinoData\\DataQuery\\AbstractDataQuery',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => true,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\DataQuery\\Decrement::__construct:0' => 
        array (
          0 => 'column',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataQuery\\Decrement::__construct:1' => 
        array (
          0 => 'sql',
          1 => 'Zend\\Db\\Sql\\Update',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataQuery\\Decrement::__construct:2' => 
        array (
          0 => 'platform',
          1 => 'Zend\\Db\\Adapter\\Platform\\PlatformInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\DataQuery\\Increment' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\DataQuery\\Toggle',
      1 => 'WebinoData\\DataQuery\\AbstractDataQuery',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => true,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\DataQuery\\Increment::__construct:0' => 
        array (
          0 => 'column',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataQuery\\Increment::__construct:1' => 
        array (
          0 => 'sql',
          1 => 'Zend\\Db\\Sql\\Update',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataQuery\\Increment::__construct:2' => 
        array (
          0 => 'platform',
          1 => 'Zend\\Db\\Adapter\\Platform\\PlatformInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\DataQuery\\AbstractDataQuery' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      '__construct' => true,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\DataQuery\\AbstractDataQuery::__construct:0' => 
        array (
          0 => 'sql',
          1 => 'Zend\\Db\\Sql\\SqlInterface',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataQuery\\AbstractDataQuery::__construct:1' => 
        array (
          0 => 'platform',
          1 => 'Zend\\Db\\Adapter\\Platform\\PlatformInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\DataQuery\\Toggle' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\DataQuery\\AbstractDataQuery',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => true,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\DataQuery\\Toggle::__construct:0' => 
        array (
          0 => 'column',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataQuery\\Toggle::__construct:1' => 
        array (
          0 => 'sql',
          1 => 'Zend\\Db\\Sql\\Update',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataQuery\\Toggle::__construct:2' => 
        array (
          0 => 'platform',
          1 => 'Zend\\Db\\Adapter\\Platform\\PlatformInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
);
