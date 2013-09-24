<?php
return array (
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
      'getEventManager' => 3,
      'getInputFilter' => 3,
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
          1 => false,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataService::setHasOneService:1' =>
        array (
          0 => 'serviceName',
          1 => false,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataService::setHasOneService:2' =>
        array (
          0 => 'options',
          1 => false,
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
          1 => false,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataService::setHasManyService:1' =>
        array (
          0 => 'serviceName',
          1 => false,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\DataService::setHasManyService:2' =>
        array (
          0 => 'options',
          1 => false,
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
);
