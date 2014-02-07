<?php 
return array (
  'Zend\\Db\\TableGateway\\TableGateway' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\Db\\TableGateway\\TableGatewayInterface',
      1 => 'Zend\\Db\\TableGateway\\AbstractTableGateway',
      2 => 'Zend\\Db\\TableGateway\\TableGatewayInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'Zend\\Db\\TableGateway\\TableGateway::__construct:0' => 
        array (
          0 => 'table',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'Zend\\Db\\TableGateway\\TableGateway::__construct:1' => 
        array (
          0 => 'adapter',
          1 => 'Zend\\Db\\Adapter\\AdapterInterface',
          2 => true,
          3 => NULL,
        ),
        'Zend\\Db\\TableGateway\\TableGateway::__construct:2' => 
        array (
          0 => 'features',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'Zend\\Db\\TableGateway\\TableGateway::__construct:3' => 
        array (
          0 => 'resultSetPrototype',
          1 => 'Zend\\Db\\ResultSet\\ResultSetInterface',
          2 => false,
          3 => NULL,
        ),
        'Zend\\Db\\TableGateway\\TableGateway::__construct:4' => 
        array (
          0 => 'sql',
          1 => 'Zend\\Db\\Sql\\Sql',
          2 => false,
          3 => NULL,
        ),
      ),
    ),
  ),
  'Zend\\Filter\\FilterChain' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\Filter\\FilterInterface',
      1 => 'Countable',
      2 => 'Zend\\Filter\\AbstractFilter',
      3 => 'Zend\\Filter\\FilterInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setOptions' => 0,
      'setPluginManager' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'Zend\\Filter\\FilterChain::__construct:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setOptions' => 
      array (
        'Zend\\Filter\\FilterChain::setOptions:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setPluginManager' => 
      array (
        'Zend\\Filter\\FilterChain::setPluginManager:0' => 
        array (
          0 => 'plugins',
          1 => 'Zend\\Filter\\FilterPluginManager',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'Zend\\InputFilter\\Factory' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setDefaultFilterChain' => 0,
      'setDefaultValidatorChain' => 0,
      'setInputFilterManager' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'Zend\\InputFilter\\Factory::__construct:0' => 
        array (
          0 => 'inputFilterManager',
          1 => 'Zend\\InputFilter\\InputFilterPluginManager',
          2 => false,
          3 => NULL,
        ),
      ),
      'setDefaultFilterChain' => 
      array (
        'Zend\\InputFilter\\Factory::setDefaultFilterChain:0' => 
        array (
          0 => 'filterChain',
          1 => 'Zend\\Filter\\FilterChain',
          2 => true,
          3 => NULL,
        ),
      ),
      'setDefaultValidatorChain' => 
      array (
        'Zend\\InputFilter\\Factory::setDefaultValidatorChain:0' => 
        array (
          0 => 'validatorChain',
          1 => 'Zend\\Validator\\ValidatorChain',
          2 => true,
          3 => NULL,
        ),
      ),
      'setInputFilterManager' => 
      array (
        'Zend\\InputFilter\\Factory::setInputFilterManager:0' => 
        array (
          0 => 'inputFilterManager',
          1 => 'Zend\\InputFilter\\InputFilterPluginManager',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'Zend\\Validator\\ValidatorChain' => 
  array (
    'supertypes' => 
    array (
      0 => 'Countable',
      1 => 'Zend\\Validator\\ValidatorInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setPluginManager' => 0,
    ),
    'parameters' => 
    array (
      'setPluginManager' => 
      array (
        'Zend\\Validator\\ValidatorChain::setPluginManager:0' => 
        array (
          0 => 'plugins',
          1 => 'Zend\\Validator\\ValidatorPluginManager',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
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
      '__construct' => 3,
      'setService' => 0,
      'setSelect' => 0,
      'setData' => 0,
      'setValidData' => 0,
      'setResult' => 0,
      'setRows' => 0,
      'setRow' => 0,
      'setUpdate' => 0,
      'setArguments' => 0,
      'setParams' => 0,
      'setName' => 0,
      'setTarget' => 0,
      'setParam' => 0,
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
      'setService' => 
      array (
        'WebinoData\\DataEvent::setService:0' => 
        array (
          0 => 'service',
          1 => 'WebinoData\\DataService',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSelect' => 
      array (
        'WebinoData\\DataEvent::setSelect:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\DataSelect',
          2 => true,
          3 => NULL,
        ),
      ),
      'setData' => 
      array (
        'WebinoData\\DataEvent::setData:0' => 
        array (
          0 => 'data',
          1 => 'ArrayAccess',
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidData' => 
      array (
        'WebinoData\\DataEvent::setValidData:0' => 
        array (
          0 => 'validData',
          1 => 'ArrayAccess',
          2 => true,
          3 => NULL,
        ),
      ),
      'setResult' => 
      array (
        'WebinoData\\DataEvent::setResult:0' => 
        array (
          0 => 'result',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRows' => 
      array (
        'WebinoData\\DataEvent::setRows:0' => 
        array (
          0 => 'rows',
          1 => 'ArrayAccess',
          2 => true,
          3 => NULL,
        ),
      ),
      'setRow' => 
      array (
        'WebinoData\\DataEvent::setRow:0' => 
        array (
          0 => 'row',
          1 => 'ArrayAccess',
          2 => true,
          3 => NULL,
        ),
      ),
      'setUpdate' => 
      array (
        'WebinoData\\DataEvent::setUpdate:0' => 
        array (
          0 => 'bool',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setArguments' => 
      array (
        'WebinoData\\DataEvent::setArguments:0' => 
        array (
          0 => 'arguments',
          1 => NULL,
          2 => true,
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
      '__construct' => 3,
      'setOverflow' => 0,
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
      '__construct' => 3,
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
      '__construct' => 3,
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
      '__construct' => 3,
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
      '__construct' => 3,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setServiceManager' => 3,
      'setPlatform' => 0,
      'setInputFilterFactory' => 3,
      'setInputFilter' => 0,
      'setHasOne' => 0,
      'setHasOneService' => 0,
      'setHasMany' => 0,
      'setHasManyService' => 0,
      'setQuery' => 0,
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
        'WebinoData\\DataService::setHasOne:2' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => false,
          3 => 
          array (
          ),
        ),
      ),
      'setHasOneService' => 
      array (
        'WebinoData\\DataService::setHasOneService:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataService::setHasOneService:1' => 
        array (
          0 => 'serviceName',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataService::setHasOneService:2' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => false,
          3 => 
          array (
          ),
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
        'WebinoData\\DataService::setHasMany:2' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => false,
          3 => 
          array (
          ),
        ),
      ),
      'setHasManyService' => 
      array (
        'WebinoData\\DataService::setHasManyService:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataService::setHasManyService:1' => 
        array (
          0 => 'serviceName',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataService::setHasManyService:2' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => false,
          3 => 
          array (
          ),
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
      '__construct' => 3,
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
      '__construct' => 3,
      'setFlag' => 0,
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
          0 => 'select',
          1 => 'Zend\\Db\\Sql\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
      'setFlag' => 
      array (
        'WebinoData\\DataSelect::setFlag:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataSelect::setFlag:1' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => false,
          3 => true,
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
      'setInputFilterFactory' => 0,
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
  'WebinoData\\InputFilter\\InputFilter' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\InputFilter\\InputFilterInterface',
      1 => 'Countable',
      2 => 'Zend\\InputFilter\\UnknownInputsCapableInterface',
      3 => 'Zend\\Stdlib\\InitializableInterface',
      4 => 'Zend\\InputFilter\\InputFilter',
      5 => 'Zend\\Stdlib\\InitializableInterface',
      6 => 'Zend\\InputFilter\\UnknownInputsCapableInterface',
      7 => 'Countable',
      8 => 'Zend\\InputFilter\\InputFilterInterface',
      9 => 'Zend\\InputFilter\\BaseInputFilter',
      10 => 'Zend\\InputFilter\\InputFilterInterface',
      11 => 'Countable',
      12 => 'Zend\\InputFilter\\UnknownInputsCapableInterface',
      13 => 'Zend\\Stdlib\\InitializableInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setFactory' => 0,
      'setData' => 0,
      'setValidationGroup' => 0,
    ),
    'parameters' => 
    array (
      'setFactory' => 
      array (
        'WebinoData\\InputFilter\\InputFilter::setFactory:0' => 
        array (
          0 => 'factory',
          1 => 'Zend\\InputFilter\\Factory',
          2 => true,
          3 => NULL,
        ),
      ),
      'setData' => 
      array (
        'WebinoData\\InputFilter\\InputFilter::setData:0' => 
        array (
          0 => 'data',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidationGroup' => 
      array (
        'WebinoData\\InputFilter\\InputFilter::setValidationGroup:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\DataPlugin\\ConfigurableInterface' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setOptions' => 0,
    ),
    'parameters' => 
    array (
      'setOptions' => 
      array (
        'WebinoData\\DataPlugin\\ConfigurableInterface::setOptions:0' => 
        array (
          0 => 'options',
          1 => NULL,
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
      '__construct' => 3,
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
  'WebinoData\\DataPlugin\\DateTimeStamp' => 
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
  'WebinoData\\DataPlugin\\AbstractConfigurable' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\DataPlugin\\ConfigurableInterface',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setOptions' => 0,
    ),
    'parameters' => 
    array (
      'setOptions' => 
      array (
        'WebinoData\\DataPlugin\\AbstractConfigurable::setOptions:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\DataPlugin\\AutoValue' => 
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
  'WebinoData\\DataPlugin\\Order' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\DataPlugin\\Order::__construct:0' => 
        array (
          0 => 'adapter',
          1 => 'Zend\\Db\\Adapter\\AdapterInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\DataPlugin\\CacheInvalidator' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\DataPlugin\\ConfigurableInterface',
      1 => 'WebinoData\\DataPlugin\\AbstractConfigurable',
      2 => 'WebinoData\\DataPlugin\\ConfigurableInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setClearByTags' => 0,
      'setOptions' => 0,
    ),
    'parameters' => 
    array (
      'setClearByTags' => 
      array (
        'WebinoData\\DataPlugin\\CacheInvalidator::setClearByTags:0' => 
        array (
          0 => 'clearByTags',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setOptions' => 
      array (
        'WebinoData\\DataPlugin\\CacheInvalidator::setOptions:0' => 
        array (
          0 => 'options',
          1 => NULL,
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
      '__construct' => 3,
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
      '__construct' => 3,
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
      '__construct' => 3,
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
      '__construct' => 3,
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
