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
      '__construct' => 3,
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
  'WebinoData\\Config\\AbstractDataService' => 
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
        'WebinoData\\Config\\AbstractDataService::setOptions:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InstanceConfigAutoloader' => 
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
        'WebinoData\\Config\\InstanceConfigAutoloader::__construct:0' => 
        array (
          0 => 'dir',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\DataService' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\AbstractDataService',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setOptions' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\DataService::__construct:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setOptions' => 
      array (
        'WebinoData\\Config\\DataService::setOptions:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\ValidableTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setValidators' => 0,
    ),
    'parameters' => 
    array (
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\ValidableTrait::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\RequirableTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setRequired' => 0,
    ),
    'parameters' => 
    array (
      'setRequired' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\RequirableTrait::setRequired:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\ForeignId' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\Id',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      3 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      4 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setNull' => 0,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\ForeignId::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\ForeignId::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\ForeignId::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\ForeignId::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Enabled' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\Toggle',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      3 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      4 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
      'setDefault' => 0,
    ),
    'parameters' => 
    array (
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Enabled::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Enabled::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Enabled::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setDefault' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Enabled::setDefault:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Hostname' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
      'setRequired' => 0,
      'setDefault' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Hostname::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Hostname::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Hostname::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Hostname::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRequired' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Hostname::setRequired:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setDefault' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Hostname::setDefault:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\AbstractInput' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
    ),
    'parameters' => 
    array (
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\AbstractInput::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\AbstractInput::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\AbstractInput::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Decimal' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
      'setRequired' => 0,
      'setDefault' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Decimal::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Decimal::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Decimal::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Decimal::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRequired' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Decimal::setRequired:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setDefault' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Decimal::setDefault:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Date' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Date::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Date::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Date::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Date::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Email' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\Common',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      3 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      4 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setMin' => 0,
      'setMax' => 0,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
      'setDefault' => 0,
      'setRequired' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Email::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setMin' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Email::setMin:0' => 
        array (
          0 => 'min',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setMax' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Email::setMax:0' => 
        array (
          0 => 'max',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Email::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Email::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Email::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setDefault' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Email::setDefault:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRequired' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Email::setRequired:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\FilterableTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setFilters' => 0,
    ),
    'parameters' => 
    array (
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\FilterableTrait::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Id' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Id::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Id::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Id::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Id::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Visible' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\Toggle',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      3 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      4 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
      'setDefault' => 0,
    ),
    'parameters' => 
    array (
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Visible::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Visible::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Visible::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setDefault' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Visible::setDefault:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\InArray' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setHaystack' => 0,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
      'setRequired' => 0,
      'setDefault' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\InArray::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setHaystack' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\InArray::setHaystack:0' => 
        array (
          0 => 'haystack',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\InArray::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\InArray::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\InArray::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRequired' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\InArray::setRequired:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setDefault' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\InArray::setDefault:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Text' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\Common',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      3 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      4 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setMin' => 0,
      'setMax' => 0,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
      'setDefault' => 0,
      'setRequired' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Text::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setMin' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Text::setMin:0' => 
        array (
          0 => 'min',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setMax' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Text::setMax:0' => 
        array (
          0 => 'max',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Text::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Text::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Text::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setDefault' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Text::setDefault:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRequired' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Text::setRequired:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Digit' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setBetween' => 0,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
      'setRequired' => 0,
      'setDefault' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Digit::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setBetween' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Digit::setBetween:0' => 
        array (
          0 => 'min',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Config\\InputFilter\\Input\\Digit::setBetween:1' => 
        array (
          0 => 'max',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Digit::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Digit::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Digit::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRequired' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Digit::setRequired:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setDefault' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Digit::setDefault:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Added' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\DateTime',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      3 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      4 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
    ),
    'parameters' => 
    array (
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Added::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Added::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Added::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Flag' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
      'setDefault' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Flag::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Flag::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Flag::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Flag::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setDefault' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Flag::setDefault:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\DefaultableTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setDefault' => 0,
    ),
    'parameters' => 
    array (
      'setDefault' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\DefaultableTrait::setDefault:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Primary' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\Id',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      3 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      4 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
    ),
    'parameters' => 
    array (
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Primary::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Primary::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Primary::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\InputInterface' => 
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
  'WebinoData\\Config\\InputFilter\\Input\\Order' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
    ),
    'parameters' => 
    array (
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Order::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Order::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Order::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Common' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setMin' => 0,
      'setMax' => 0,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
      'setDefault' => 0,
      'setRequired' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Common::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setMin' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Common::setMin:0' => 
        array (
          0 => 'min',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setMax' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Common::setMax:0' => 
        array (
          0 => 'max',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Common::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Common::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Common::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setDefault' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Common::setDefault:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRequired' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Common::setRequired:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Updated' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\DateTime',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      3 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      4 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
    ),
    'parameters' => 
    array (
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Updated::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Updated::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Updated::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\Toggle' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
      'setDefault' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Toggle::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Toggle::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Toggle::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Toggle::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setDefault' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\Toggle::setDefault:0' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\Input\\DateTime' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
      1 => 'WebinoData\\Config\\InputFilter\\Input\\AbstractInput',
      2 => 'WebinoData\\Config\\InputFilter\\Input\\InputInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFilters' => 0,
      'setValidators' => 0,
      'setAllowedValues' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\DateTime::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilters' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\DateTime::setFilters:0' => 
        array (
          0 => 'filters',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidators' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\DateTime::setValidators:0' => 
        array (
          0 => 'validators',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setAllowedValues' => 
      array (
        'WebinoData\\Config\\InputFilter\\Input\\DateTime::setAllowedValues:0' => 
        array (
          0 => 'values',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Config\\InputFilter\\InputFilter' => 
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
        'WebinoData\\Config\\InputFilter\\InputFilter::__construct:0' => 
        array (
          0 => 'input',
          1 => NULL,
          2 => false,
          3 => 
          array (
          ),
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
  'WebinoData\\Exception\\RelationException' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Exception\\ExceptionInterface',
      1 => 'Throwable',
      2 => 'WebinoData\\Exception\\RuntimeException',
      3 => 'Throwable',
      4 => 'WebinoData\\Exception\\ExceptionInterface',
      5 => 'RuntimeException',
      6 => 'Throwable',
      7 => 'Exception',
      8 => 'Throwable',
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
        'WebinoData\\Exception\\RelationException::__construct:0' => 
        array (
          0 => 'message',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\Exception\\RelationException::__construct:1' => 
        array (
          0 => 'code',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\Exception\\RelationException::__construct:2' => 
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
      0 => 'Throwable',
      1 => 'WebinoData\\Exception\\ExceptionInterface',
      2 => 'RuntimeException',
      3 => 'Throwable',
      4 => 'Exception',
      5 => 'Throwable',
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
  'WebinoData\\Exception\\MissingPropertyException' => 
  array (
    'supertypes' => 
    array (
      0 => 'Throwable',
      1 => 'WebinoData\\Exception\\ExceptionInterface',
      2 => 'InvalidArgumentException',
      3 => 'Throwable',
      4 => 'LogicException',
      5 => 'Throwable',
      6 => 'Exception',
      7 => 'Throwable',
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
  'WebinoData\\Exception\\InvalidArgumentException' => 
  array (
    'supertypes' => 
    array (
      0 => 'Throwable',
      1 => 'WebinoData\\Exception\\ExceptionInterface',
      2 => 'InvalidArgumentException',
      3 => 'Throwable',
      4 => 'LogicException',
      5 => 'Throwable',
      6 => 'Exception',
      7 => 'Throwable',
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
  'WebinoData\\Store\\StoreInterface' => 
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
  'WebinoData\\Store\\QueryTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setToggleQuery' => 0,
      'setIncrementQuery' => 0,
      'setDecrementQuery' => 0,
    ),
    'parameters' => 
    array (
      'setToggleQuery' => 
      array (
        'WebinoData\\Store\\QueryTrait::setToggleQuery:0' => 
        array (
          0 => 'query',
          1 => 'WebinoData\\Query\\Toggle',
          2 => true,
          3 => NULL,
        ),
      ),
      'setIncrementQuery' => 
      array (
        'WebinoData\\Store\\QueryTrait::setIncrementQuery:0' => 
        array (
          0 => 'query',
          1 => 'WebinoData\\Query\\Increment',
          2 => true,
          3 => NULL,
        ),
      ),
      'setDecrementQuery' => 
      array (
        'WebinoData\\Store\\QueryTrait::setDecrementQuery:0' => 
        array (
          0 => 'query',
          1 => 'WebinoData\\Query\\Decrement',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Store\\EventsTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setEvent' => 0,
      'setEventManager' => 0,
    ),
    'parameters' => 
    array (
      'setEvent' => 
      array (
        'WebinoData\\Store\\EventsTrait::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoData\\Event\\DataEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoData\\Store\\EventsTrait::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Store\\OutputTrait' => 
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
  'WebinoData\\Store\\RelationsTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setHasOne' => 0,
      'setHasOneService' => 0,
      'setHasMany' => 0,
      'setHasManyService' => 0,
    ),
    'parameters' => 
    array (
      'setHasOne' => 
      array (
        'WebinoData\\Store\\RelationsTrait::setHasOne:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\RelationsTrait::setHasOne:1' => 
        array (
          0 => 'store',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\RelationsTrait::setHasOne:2' => 
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
        'WebinoData\\Store\\RelationsTrait::setHasOneService:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\RelationsTrait::setHasOneService:1' => 
        array (
          0 => 'storeName',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\RelationsTrait::setHasOneService:2' => 
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
        'WebinoData\\Store\\RelationsTrait::setHasMany:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\RelationsTrait::setHasMany:1' => 
        array (
          0 => 'store',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\RelationsTrait::setHasMany:2' => 
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
        'WebinoData\\Store\\RelationsTrait::setHasManyService:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\RelationsTrait::setHasManyService:1' => 
        array (
          0 => 'storeName',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\RelationsTrait::setHasManyService:2' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => false,
          3 => 
          array (
          ),
        ),
      ),
    ),
  ),
  'WebinoData\\Store\\AbstractStore' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventManagerAwareInterface',
      1 => 'Zend\\EventManager\\EventsCapableInterface',
      2 => 'Zend\\ServiceManager\\ServiceManagerAwareInterface',
      3 => 'WebinoData\\InputFilter\\InputFilterFactoryAwareInterface',
      4 => 'WebinoData\\Store\\StoreInterface',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      '__construct' => 3,
      'setServiceManager' => 3,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setInputFilterFactory' => 3,
      'setInputFilter' => 0,
      'setToggleQuery' => 0,
      'setIncrementQuery' => 0,
      'setDecrementQuery' => 0,
      'setHasOne' => 0,
      'setHasOneService' => 0,
      'setHasMany' => 0,
      'setHasManyService' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Store\\AbstractStore::__construct:0' => 
        array (
          0 => 'table',
          1 => 'Zend\\Db\\TableGateway\\TableGateway',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\AbstractStore::__construct:1' => 
        array (
          0 => 'config',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setServiceManager' => 
      array (
        'WebinoData\\Store\\AbstractStore::setServiceManager:0' => 
        array (
          0 => 'serviceManager',
          1 => 'Zend\\ServiceManager\\ServiceManager',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoData\\Store\\AbstractStore::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoData\\Event\\DataEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoData\\Store\\AbstractStore::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setInputFilterFactory' => 
      array (
        'WebinoData\\Store\\AbstractStore::setInputFilterFactory:0' => 
        array (
          0 => 'inputFilter',
          1 => 'Zend\\InputFilter\\Factory',
          2 => true,
          3 => NULL,
        ),
      ),
      'setInputFilter' => 
      array (
        'WebinoData\\Store\\AbstractStore::setInputFilter:0' => 
        array (
          0 => 'inputFilter',
          1 => 'Zend\\InputFilter\\InputFilterInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setToggleQuery' => 
      array (
        'WebinoData\\Store\\AbstractStore::setToggleQuery:0' => 
        array (
          0 => 'query',
          1 => 'WebinoData\\Query\\Toggle',
          2 => true,
          3 => NULL,
        ),
      ),
      'setIncrementQuery' => 
      array (
        'WebinoData\\Store\\AbstractStore::setIncrementQuery:0' => 
        array (
          0 => 'query',
          1 => 'WebinoData\\Query\\Increment',
          2 => true,
          3 => NULL,
        ),
      ),
      'setDecrementQuery' => 
      array (
        'WebinoData\\Store\\AbstractStore::setDecrementQuery:0' => 
        array (
          0 => 'query',
          1 => 'WebinoData\\Query\\Decrement',
          2 => true,
          3 => NULL,
        ),
      ),
      'setHasOne' => 
      array (
        'WebinoData\\Store\\AbstractStore::setHasOne:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\AbstractStore::setHasOne:1' => 
        array (
          0 => 'store',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\AbstractStore::setHasOne:2' => 
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
        'WebinoData\\Store\\AbstractStore::setHasOneService:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\AbstractStore::setHasOneService:1' => 
        array (
          0 => 'storeName',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\AbstractStore::setHasOneService:2' => 
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
        'WebinoData\\Store\\AbstractStore::setHasMany:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\AbstractStore::setHasMany:1' => 
        array (
          0 => 'store',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\AbstractStore::setHasMany:2' => 
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
        'WebinoData\\Store\\AbstractStore::setHasManyService:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\AbstractStore::setHasManyService:1' => 
        array (
          0 => 'storeName',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store\\AbstractStore::setHasManyService:2' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => false,
          3 => 
          array (
          ),
        ),
      ),
    ),
  ),
  'WebinoData\\Store\\SyncTrait' => 
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
  'WebinoData\\Store\\StoreAwareInterface' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setStore' => 0,
    ),
    'parameters' => 
    array (
      'setStore' => 
      array (
        'WebinoData\\Store\\StoreAwareInterface::setStore:0' => 
        array (
          0 => 'store',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Store\\TraitBase' => 
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
  'WebinoData\\Store\\PluginTrait' => 
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
  'WebinoData\\Store\\PurgeTrait' => 
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
  'WebinoData\\Store\\SelectTrait' => 
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
  'WebinoData\\Store\\InputTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setInputFilterFactory' => 0,
      'setInputFilter' => 0,
    ),
    'parameters' => 
    array (
      'setInputFilterFactory' => 
      array (
        'WebinoData\\Store\\InputTrait::setInputFilterFactory:0' => 
        array (
          0 => 'factory',
          1 => 'Zend\\InputFilter\\Factory',
          2 => true,
          3 => NULL,
        ),
      ),
      'setInputFilter' => 
      array (
        'WebinoData\\Store\\InputTrait::setInputFilter:0' => 
        array (
          0 => 'inputFilter',
          1 => 'Zend\\InputFilter\\InputFilterInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Store\\SchemaTrait' => 
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
  'WebinoData\\Store\\StoreAwareTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setStore' => 0,
    ),
    'parameters' => 
    array (
      'setStore' => 
      array (
        'WebinoData\\Store\\StoreAwareTrait::setStore:0' => 
        array (
          0 => 'store',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Listener\\CacheInvalidatorListener' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\SharedListenerAggregateInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setCache' => 0,
    ),
    'parameters' => 
    array (
      'setCache' => 
      array (
        'WebinoData\\Listener\\CacheInvalidatorListener::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\Adapter\\Filesystem',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Event\\DataEvent' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\EventManager\\EventInterface',
      1 => 'WebinoData\\Event\\DataEventInterface',
      2 => 'Zend\\EventManager\\Event',
      3 => 'Zend\\EventManager\\EventInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setStore' => 0,
      'setService' => 0,
      'setSelect' => 0,
      'setData' => 0,
      'setValidData' => 0,
      'setResult' => 0,
      'setRows' => 0,
      'setRow' => 0,
      'setAffectedRows' => 0,
      'setUpdate' => 0,
      'setArguments' => 0,
      'setWherePredicate' => 0,
      'setWhereCombination' => 0,
      'setJoinOn' => 0,
      'setJoinColumns' => 0,
      'setParams' => 0,
      'setName' => 0,
      'setTarget' => 0,
      'setParam' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Event\\DataEvent::__construct:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\Event\\DataEvent::__construct:1' => 
        array (
          0 => 'target',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\Event\\DataEvent::__construct:2' => 
        array (
          0 => 'params',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setStore' => 
      array (
        'WebinoData\\Event\\DataEvent::setStore:0' => 
        array (
          0 => 'store',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setService' => 
      array (
        'WebinoData\\Event\\DataEvent::setService:0' => 
        array (
          0 => 'store',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSelect' => 
      array (
        'WebinoData\\Event\\DataEvent::setSelect:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
      'setData' => 
      array (
        'WebinoData\\Event\\DataEvent::setData:0' => 
        array (
          0 => 'data',
          1 => 'ArrayObject',
          2 => true,
          3 => NULL,
        ),
      ),
      'setValidData' => 
      array (
        'WebinoData\\Event\\DataEvent::setValidData:0' => 
        array (
          0 => 'validData',
          1 => 'ArrayObject',
          2 => true,
          3 => NULL,
        ),
      ),
      'setResult' => 
      array (
        'WebinoData\\Event\\DataEvent::setResult:0' => 
        array (
          0 => 'result',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setRows' => 
      array (
        'WebinoData\\Event\\DataEvent::setRows:0' => 
        array (
          0 => 'rows',
          1 => 'ArrayObject',
          2 => true,
          3 => NULL,
        ),
      ),
      'setRow' => 
      array (
        'WebinoData\\Event\\DataEvent::setRow:0' => 
        array (
          0 => 'row',
          1 => 'ArrayObject',
          2 => true,
          3 => NULL,
        ),
      ),
      'setAffectedRows' => 
      array (
        'WebinoData\\Event\\DataEvent::setAffectedRows:0' => 
        array (
          0 => 'affectedRows',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setUpdate' => 
      array (
        'WebinoData\\Event\\DataEvent::setUpdate:0' => 
        array (
          0 => 'bool',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setArguments' => 
      array (
        'WebinoData\\Event\\DataEvent::setArguments:0' => 
        array (
          0 => 'arguments',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setWherePredicate' => 
      array (
        'WebinoData\\Event\\DataEvent::setWherePredicate:0' => 
        array (
          0 => 'predicate',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setWhereCombination' => 
      array (
        'WebinoData\\Event\\DataEvent::setWhereCombination:0' => 
        array (
          0 => 'combination',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setJoinOn' => 
      array (
        'WebinoData\\Event\\DataEvent::setJoinOn:0' => 
        array (
          0 => 'on',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setJoinColumns' => 
      array (
        'WebinoData\\Event\\DataEvent::setJoinColumns:0' => 
        array (
          0 => 'columns',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setParams' => 
      array (
        'WebinoData\\Event\\DataEvent::setParams:0' => 
        array (
          0 => 'params',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setName' => 
      array (
        'WebinoData\\Event\\DataEvent::setName:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setTarget' => 
      array (
        'WebinoData\\Event\\DataEvent::setTarget:0' => 
        array (
          0 => 'target',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setParam' => 
      array (
        'WebinoData\\Event\\DataEvent::setParam:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Event\\DataEvent::setParam:1' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Event\\DataEventInterface' => 
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
  'WebinoData\\Store' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Store\\StoreInterface',
      1 => 'WebinoData\\InputFilter\\InputFilterFactoryAwareInterface',
      2 => 'Zend\\ServiceManager\\ServiceManagerAwareInterface',
      3 => 'Zend\\EventManager\\EventsCapableInterface',
      4 => 'Zend\\EventManager\\EventManagerAwareInterface',
      5 => 'WebinoData\\Store\\AbstractStore',
      6 => 'Zend\\EventManager\\EventManagerAwareInterface',
      7 => 'Zend\\EventManager\\EventsCapableInterface',
      8 => 'Zend\\ServiceManager\\ServiceManagerAwareInterface',
      9 => 'WebinoData\\InputFilter\\InputFilterFactoryAwareInterface',
      10 => 'WebinoData\\Store\\StoreInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setCache' => 0,
      'setCacheTags' => 0,
      'setServiceManager' => 3,
      'setEvent' => 0,
      'setEventManager' => 3,
      'setInputFilterFactory' => 3,
      'setInputFilter' => 0,
      'setToggleQuery' => 0,
      'setIncrementQuery' => 0,
      'setDecrementQuery' => 0,
      'setHasOne' => 0,
      'setHasOneService' => 0,
      'setHasMany' => 0,
      'setHasManyService' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Store::__construct:0' => 
        array (
          0 => 'table',
          1 => 'Zend\\Db\\TableGateway\\TableGateway',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store::__construct:1' => 
        array (
          0 => 'config',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setCache' => 
      array (
        'WebinoData\\Store::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\Adapter\\Filesystem',
          2 => false,
          3 => NULL,
        ),
      ),
      'setCacheTags' => 
      array (
        'WebinoData\\Store::setCacheTags:0' => 
        array (
          0 => 'tags',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setServiceManager' => 
      array (
        'WebinoData\\Store::setServiceManager:0' => 
        array (
          0 => 'serviceManager',
          1 => 'Zend\\ServiceManager\\ServiceManager',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEvent' => 
      array (
        'WebinoData\\Store::setEvent:0' => 
        array (
          0 => 'event',
          1 => 'WebinoData\\Event\\DataEvent',
          2 => true,
          3 => NULL,
        ),
      ),
      'setEventManager' => 
      array (
        'WebinoData\\Store::setEventManager:0' => 
        array (
          0 => 'eventManager',
          1 => 'Zend\\EventManager\\EventManagerInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setInputFilterFactory' => 
      array (
        'WebinoData\\Store::setInputFilterFactory:0' => 
        array (
          0 => 'inputFilter',
          1 => 'Zend\\InputFilter\\Factory',
          2 => true,
          3 => NULL,
        ),
      ),
      'setInputFilter' => 
      array (
        'WebinoData\\Store::setInputFilter:0' => 
        array (
          0 => 'inputFilter',
          1 => 'Zend\\InputFilter\\InputFilterInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setToggleQuery' => 
      array (
        'WebinoData\\Store::setToggleQuery:0' => 
        array (
          0 => 'query',
          1 => 'WebinoData\\Query\\Toggle',
          2 => true,
          3 => NULL,
        ),
      ),
      'setIncrementQuery' => 
      array (
        'WebinoData\\Store::setIncrementQuery:0' => 
        array (
          0 => 'query',
          1 => 'WebinoData\\Query\\Increment',
          2 => true,
          3 => NULL,
        ),
      ),
      'setDecrementQuery' => 
      array (
        'WebinoData\\Store::setDecrementQuery:0' => 
        array (
          0 => 'query',
          1 => 'WebinoData\\Query\\Decrement',
          2 => true,
          3 => NULL,
        ),
      ),
      'setHasOne' => 
      array (
        'WebinoData\\Store::setHasOne:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store::setHasOne:1' => 
        array (
          0 => 'store',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store::setHasOne:2' => 
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
        'WebinoData\\Store::setHasOneService:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store::setHasOneService:1' => 
        array (
          0 => 'storeName',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store::setHasOneService:2' => 
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
        'WebinoData\\Store::setHasMany:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store::setHasMany:1' => 
        array (
          0 => 'store',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store::setHasMany:2' => 
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
        'WebinoData\\Store::setHasManyService:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store::setHasManyService:1' => 
        array (
          0 => 'storeName',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Store::setHasManyService:2' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => false,
          3 => 
          array (
          ),
        ),
      ),
    ),
  ),
  'WebinoData\\Filter\\DateTimeFormatter' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\Filter\\FilterInterface',
      1 => 'Zend\\Filter\\DateTimeFormatter',
      2 => 'Zend\\Filter\\FilterInterface',
      3 => 'Zend\\Filter\\AbstractFilter',
      4 => 'Zend\\Filter\\FilterInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setFormat' => 0,
      'setOptions' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Filter\\DateTimeFormatter::__construct:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setFormat' => 
      array (
        'WebinoData\\Filter\\DateTimeFormatter::setFormat:0' => 
        array (
          0 => 'format',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setOptions' => 
      array (
        'WebinoData\\Filter\\DateTimeFormatter::setOptions:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Filter\\ToFloat' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\Filter\\FilterInterface',
      1 => 'Zend\\Filter\\AbstractFilter',
      2 => 'Zend\\Filter\\FilterInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setOptions' => 0,
    ),
    'parameters' => 
    array (
      'setOptions' => 
      array (
        'WebinoData\\Filter\\ToFloat::setOptions:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Paginator\\PaginatorSelect' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\Paginator\\Adapter\\AdapterInterface',
      1 => 'Countable',
      2 => 'WebinoData\\Paginator\\AbstractPaginatorSelect',
      3 => 'Countable',
      4 => 'Zend\\Paginator\\Adapter\\AdapterInterface',
      5 => 'Zend\\Paginator\\Adapter\\DbSelect',
      6 => 'Zend\\Paginator\\Adapter\\AdapterInterface',
      7 => 'Countable',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setCache' => 0,
      'setCacheTags' => 0,
      'setOverflow' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Paginator\\PaginatorSelect::__construct:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Paginator\\PaginatorSelect::__construct:1' => 
        array (
          0 => 'store',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setCache' => 
      array (
        'WebinoData\\Paginator\\PaginatorSelect::setCache:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\Adapter\\Filesystem',
          2 => true,
          3 => NULL,
        ),
      ),
      'setCacheTags' => 
      array (
        'WebinoData\\Paginator\\PaginatorSelect::setCacheTags:0' => 
        array (
          0 => 'tags',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setOverflow' => 
      array (
        'WebinoData\\Paginator\\PaginatorSelect::setOverflow:0' => 
        array (
          0 => 'overflow',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Paginator\\AbstractPaginatorSelect' => 
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
        'WebinoData\\Paginator\\AbstractPaginatorSelect::__construct:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Paginator\\AbstractPaginatorSelect::__construct:1' => 
        array (
          0 => 'dataStore',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setOverflow' => 
      array (
        'WebinoData\\Paginator\\AbstractPaginatorSelect::setOverflow:0' => 
        array (
          0 => 'overflow',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\ColumnsTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setColumnsHelper' => 0,
    ),
    'parameters' => 
    array (
      'setColumnsHelper' => 
      array (
        'WebinoData\\Select\\ColumnsTrait::setColumnsHelper:0' => 
        array (
          0 => 'columnsHelper',
          1 => 'WebinoData\\Select\\Columns',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\ArrayColumn' => 
  array (
    'supertypes' => 
    array (
      0 => 'Countable',
      1 => 'Serializable',
      2 => 'ArrayAccess',
      3 => 'Traversable',
      4 => 'IteratorAggregate',
      5 => 'ArrayObject',
      6 => 'IteratorAggregate',
      7 => 'Traversable',
      8 => 'ArrayAccess',
      9 => 'Serializable',
      10 => 'Countable',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setPattern' => 0,
      'setFlags' => 0,
      'setIteratorClass' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Select\\ArrayColumn::__construct:0' => 
        array (
          0 => 'array',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\Select\\ArrayColumn::__construct:1' => 
        array (
          0 => 'ar_flags',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
        'WebinoData\\Select\\ArrayColumn::__construct:2' => 
        array (
          0 => 'iterator_class',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setPattern' => 
      array (
        'WebinoData\\Select\\ArrayColumn::setPattern:0' => 
        array (
          0 => 'pattern',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFlags' => 
      array (
        'WebinoData\\Select\\ArrayColumn::setFlags:0' => 
        array (
          0 => 'flags',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setIteratorClass' => 
      array (
        'WebinoData\\Select\\ArrayColumn::setIteratorClass:0' => 
        array (
          0 => 'iteratorClass',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\Join' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Select\\AbstractHelper',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setSelect' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Select\\Join::__construct:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSelect' => 
      array (
        'WebinoData\\Select\\Join::setSelect:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\LimitTrait' => 
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
  'WebinoData\\Select\\Configure' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Select\\AbstractHelper',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setSelect' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Select\\Configure::__construct:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSelect' => 
      array (
        'WebinoData\\Select\\Configure::setSelect:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\Search' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Select\\AbstractHelper',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setSelect' => 0,
      'setSanitize' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Select\\Search::__construct:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSelect' => 
      array (
        'WebinoData\\Select\\Search::setSelect:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSanitize' => 
      array (
        'WebinoData\\Select\\Search::setSanitize:0' => 
        array (
          0 => 'sanitize',
          1 => 'WebinoI18nSanitizeLib\\Sanitize',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\AbstractHelper' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      '__construct' => 3,
      'setSelect' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Select\\AbstractHelper::__construct:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSelect' => 
      array (
        'WebinoData\\Select\\AbstractHelper::setSelect:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\Columns' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Select\\AbstractHelper',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setColumns' => 0,
      'setSelect' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Select\\Columns::__construct:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
      'setColumns' => 
      array (
        'WebinoData\\Select\\Columns::setColumns:0' => 
        array (
          0 => 'columns',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setSelect' => 
      array (
        'WebinoData\\Select\\Columns::setSelect:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\CombineTrait' => 
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
  'WebinoData\\Select\\OrderTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setOrderHelper' => 0,
    ),
    'parameters' => 
    array (
      'setOrderHelper' => 
      array (
        'WebinoData\\Select\\OrderTrait::setOrderHelper:0' => 
        array (
          0 => 'orderHelper',
          1 => 'WebinoData\\Select\\Order',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\SearchTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setSearchHelper' => 0,
    ),
    'parameters' => 
    array (
      'setSearchHelper' => 
      array (
        'WebinoData\\Select\\SearchTrait::setSearchHelper:0' => 
        array (
          0 => 'searchHelper',
          1 => 'WebinoData\\Select\\Search',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\RawStateTrait' => 
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
  'WebinoData\\Select\\ResetTrait' => 
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
  'WebinoData\\Select\\HavingTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setSubParams' => 0,
    ),
    'parameters' => 
    array (
      'setSubParams' => 
      array (
        'WebinoData\\Select\\HavingTrait::setSubParams:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Select\\HavingTrait::setSubParams:1' => 
        array (
          0 => 'params',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\Where' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Select\\AbstractHelper',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setSelect' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Select\\Where::__construct:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSelect' => 
      array (
        'WebinoData\\Select\\Where::setSelect:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\ExpressionTrait' => 
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
  'WebinoData\\Select\\PredicateTrait' => 
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
  'WebinoData\\Select\\Order' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Select\\AbstractHelper',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setSelect' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Select\\Order::__construct:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSelect' => 
      array (
        'WebinoData\\Select\\Order::setSelect:0' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\WhereTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setWhereHelper' => 0,
    ),
    'parameters' => 
    array (
      'setWhereHelper' => 
      array (
        'WebinoData\\Select\\WhereTrait::setWhereHelper:0' => 
        array (
          0 => 'whereHelper',
          1 => 'WebinoData\\Select\\Where',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\ConfigureTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setConfigureHelper' => 0,
    ),
    'parameters' => 
    array (
      'setConfigureHelper' => 
      array (
        'WebinoData\\Select\\ConfigureTrait::setConfigureHelper:0' => 
        array (
          0 => 'configureHelper',
          1 => 'WebinoData\\Select\\Configure',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\JoinTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setJoinHelper' => 0,
    ),
    'parameters' => 
    array (
      'setJoinHelper' => 
      array (
        'WebinoData\\Select\\JoinTrait::setJoinHelper:0' => 
        array (
          0 => 'joinHelper',
          1 => 'WebinoData\\Select\\Join',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select\\GroupTrait' => 
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
  'WebinoData\\Paginator' => 
  array (
    'supertypes' => 
    array (
      0 => 'Traversable',
      1 => 'IteratorAggregate',
      2 => 'Countable',
      3 => 'Zend\\Paginator\\Paginator',
      4 => 'Countable',
      5 => 'IteratorAggregate',
      6 => 'Traversable',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setCacheEnabled' => 0,
      'setCurrentPageNumber' => 0,
      'setFilter' => 0,
      'setItemCountPerPage' => 0,
      'setPageRange' => 0,
      'setView' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Paginator::__construct:0' => 
        array (
          0 => 'adapter',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setCacheEnabled' => 
      array (
        'WebinoData\\Paginator::setCacheEnabled:0' => 
        array (
          0 => 'enable',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setCurrentPageNumber' => 
      array (
        'WebinoData\\Paginator::setCurrentPageNumber:0' => 
        array (
          0 => 'pageNumber',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFilter' => 
      array (
        'WebinoData\\Paginator::setFilter:0' => 
        array (
          0 => 'filter',
          1 => 'Zend\\Filter\\FilterInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setItemCountPerPage' => 
      array (
        'WebinoData\\Paginator::setItemCountPerPage:0' => 
        array (
          0 => 'itemCountPerPage',
          1 => NULL,
          2 => false,
          3 => -1,
        ),
      ),
      'setPageRange' => 
      array (
        'WebinoData\\Paginator::setPageRange:0' => 
        array (
          0 => 'pageRange',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setView' => 
      array (
        'WebinoData\\Paginator::setView:0' => 
        array (
          0 => 'view',
          1 => 'Zend\\View\\Renderer\\RendererInterface',
          2 => false,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Select' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setHash' => 0,
      'setFlag' => 0,
      'setSubSelect' => 0,
      'setSubParams' => 0,
      'setColumnsHelper' => 0,
      'setConfigureHelper' => 0,
      'setJoinHelper' => 0,
      'setOrderHelper' => 0,
      'setSearchHelper' => 0,
      'setWhereHelper' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Select::__construct:0' => 
        array (
          0 => 'store',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Select::__construct:1' => 
        array (
          0 => 'select',
          1 => 'Zend\\Db\\Sql\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
      'setHash' => 
      array (
        'WebinoData\\Select::setHash:0' => 
        array (
          0 => 'hash',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setFlag' => 
      array (
        'WebinoData\\Select::setFlag:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Select::setFlag:1' => 
        array (
          0 => 'value',
          1 => NULL,
          2 => false,
          3 => true,
        ),
      ),
      'setSubSelect' => 
      array (
        'WebinoData\\Select::setSubSelect:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Select::setSubSelect:1' => 
        array (
          0 => 'select',
          1 => 'WebinoData\\Select',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSubParams' => 
      array (
        'WebinoData\\Select::setSubParams:0' => 
        array (
          0 => 'name',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Select::setSubParams:1' => 
        array (
          0 => 'params',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setColumnsHelper' => 
      array (
        'WebinoData\\Select::setColumnsHelper:0' => 
        array (
          0 => 'columnsHelper',
          1 => 'WebinoData\\Select\\Columns',
          2 => true,
          3 => NULL,
        ),
      ),
      'setConfigureHelper' => 
      array (
        'WebinoData\\Select::setConfigureHelper:0' => 
        array (
          0 => 'configureHelper',
          1 => 'WebinoData\\Select\\Configure',
          2 => true,
          3 => NULL,
        ),
      ),
      'setJoinHelper' => 
      array (
        'WebinoData\\Select::setJoinHelper:0' => 
        array (
          0 => 'joinHelper',
          1 => 'WebinoData\\Select\\Join',
          2 => true,
          3 => NULL,
        ),
      ),
      'setOrderHelper' => 
      array (
        'WebinoData\\Select::setOrderHelper:0' => 
        array (
          0 => 'orderHelper',
          1 => 'WebinoData\\Select\\Order',
          2 => true,
          3 => NULL,
        ),
      ),
      'setSearchHelper' => 
      array (
        'WebinoData\\Select::setSearchHelper:0' => 
        array (
          0 => 'searchHelper',
          1 => 'WebinoData\\Select\\Search',
          2 => true,
          3 => NULL,
        ),
      ),
      'setWhereHelper' => 
      array (
        'WebinoData\\Select::setWhereHelper:0' => 
        array (
          0 => 'whereHelper',
          1 => 'WebinoData\\Select\\Where',
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
      4 => 'Zend\\InputFilter\\ReplaceableInputInterface',
      5 => 'Zend\\InputFilter\\InputFilter',
      6 => 'Zend\\InputFilter\\ReplaceableInputInterface',
      7 => 'Zend\\Stdlib\\InitializableInterface',
      8 => 'Zend\\InputFilter\\UnknownInputsCapableInterface',
      9 => 'Countable',
      10 => 'Zend\\InputFilter\\InputFilterInterface',
      11 => 'Zend\\InputFilter\\BaseInputFilter',
      12 => 'Zend\\InputFilter\\InputFilterInterface',
      13 => 'Countable',
      14 => 'Zend\\InputFilter\\UnknownInputsCapableInterface',
      15 => 'Zend\\Stdlib\\InitializableInterface',
      16 => 'Zend\\InputFilter\\ReplaceableInputInterface',
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
  'WebinoData\\Plugin\\OptionsInterface' => 
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
        'WebinoData\\Plugin\\OptionsInterface::setOptions:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Plugin\\CacheInvalidator' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Plugin\\OptionsInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setClearByTags' => 0,
      'setClearByDateTime' => 0,
      'setOptions' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Plugin\\CacheInvalidator::__construct:0' => 
        array (
          0 => 'cache',
          1 => 'Zend\\Cache\\Storage\\Adapter\\Filesystem',
          2 => true,
          3 => NULL,
        ),
      ),
      'setClearByTags' => 
      array (
        'WebinoData\\Plugin\\CacheInvalidator::setClearByTags:0' => 
        array (
          0 => 'clearByTags',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setClearByDateTime' => 
      array (
        'WebinoData\\Plugin\\CacheInvalidator::setClearByDateTime:0' => 
        array (
          0 => 'clearByDateTime',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setOptions' => 
      array (
        'WebinoData\\Plugin\\CacheInvalidator::setOptions:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Plugin\\OrderInterface' => 
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
  'WebinoData\\Plugin\\OptionsTrait' => 
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
        'WebinoData\\Plugin\\OptionsTrait::setOptions:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Plugin\\Relations' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Store\\StoreAwareInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      'setStore' => 3,
    ),
    'parameters' => 
    array (
      'setStore' => 
      array (
        'WebinoData\\Plugin\\Relations::setStore:0' => 
        array (
          0 => 'store',
          1 => 'WebinoData\\Store\\StoreInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Plugin\\DateTimeStamp' => 
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
  'WebinoData\\Plugin\\Order' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Plugin\\OrderInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoData\\Plugin\\AutoValue' => 
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
  'WebinoData\\Query\\IncrementTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setIncrementQuery' => 0,
    ),
    'parameters' => 
    array (
      'setIncrementQuery' => 
      array (
        'WebinoData\\Query\\IncrementTrait::setIncrementQuery:0' => 
        array (
          0 => 'query',
          1 => 'WebinoData\\Query\\Increment',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Query\\DecrementTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setDecrementQuery' => 0,
    ),
    'parameters' => 
    array (
      'setDecrementQuery' => 
      array (
        'WebinoData\\Query\\DecrementTrait::setDecrementQuery:0' => 
        array (
          0 => 'query',
          1 => 'WebinoData\\Query\\Decrement',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Query\\AbstractUpdate' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Query\\AbstractQuery',
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      '__construct' => 3,
      'setColumns' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Query\\AbstractUpdate::__construct:0' => 
        array (
          0 => 'sql',
          1 => 'Zend\\Db\\Sql\\Update',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Query\\AbstractUpdate::__construct:1' => 
        array (
          0 => 'platform',
          1 => 'Zend\\Db\\Adapter\\Platform\\PlatformInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setColumns' => 
      array (
        'WebinoData\\Query\\AbstractUpdate::setColumns:0' => 
        array (
          0 => 'columns',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Query\\TraitBase' => 
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
  'WebinoData\\Query\\Decrement' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Query\\AbstractUpdate',
      1 => 'WebinoData\\Query\\AbstractQuery',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setColumns' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Query\\Decrement::__construct:0' => 
        array (
          0 => 'sql',
          1 => 'Zend\\Db\\Sql\\Update',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Query\\Decrement::__construct:1' => 
        array (
          0 => 'platform',
          1 => 'Zend\\Db\\Adapter\\Platform\\PlatformInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setColumns' => 
      array (
        'WebinoData\\Query\\Decrement::setColumns:0' => 
        array (
          0 => 'columns',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Query\\AbstractQuery' => 
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
        'WebinoData\\Query\\AbstractQuery::__construct:0' => 
        array (
          0 => 'sql',
          1 => 'Zend\\Db\\Sql\\AbstractPreparableSql',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Query\\AbstractQuery::__construct:1' => 
        array (
          0 => 'platform',
          1 => 'Zend\\Db\\Adapter\\Platform\\PlatformInterface',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Query\\ToggleTrait' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => NULL,
    'methods' => 
    array (
      'setToggleQuery' => 0,
    ),
    'parameters' => 
    array (
      'setToggleQuery' => 
      array (
        'WebinoData\\Query\\ToggleTrait::setToggleQuery:0' => 
        array (
          0 => 'query',
          1 => 'WebinoData\\Query\\Toggle',
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Query\\Increment' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Query\\AbstractUpdate',
      1 => 'WebinoData\\Query\\AbstractQuery',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setColumns' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Query\\Increment::__construct:0' => 
        array (
          0 => 'sql',
          1 => 'Zend\\Db\\Sql\\Update',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Query\\Increment::__construct:1' => 
        array (
          0 => 'platform',
          1 => 'Zend\\Db\\Adapter\\Platform\\PlatformInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setColumns' => 
      array (
        'WebinoData\\Query\\Increment::setColumns:0' => 
        array (
          0 => 'columns',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoData\\Query\\Toggle' => 
  array (
    'supertypes' => 
    array (
      0 => 'WebinoData\\Query\\AbstractUpdate',
      1 => 'WebinoData\\Query\\AbstractQuery',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setColumns' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoData\\Query\\Toggle::__construct:0' => 
        array (
          0 => 'sql',
          1 => 'Zend\\Db\\Sql\\Update',
          2 => true,
          3 => NULL,
        ),
        'WebinoData\\Query\\Toggle::__construct:1' => 
        array (
          0 => 'platform',
          1 => 'Zend\\Db\\Adapter\\Platform\\PlatformInterface',
          2 => true,
          3 => NULL,
        ),
      ),
      'setColumns' => 
      array (
        'WebinoData\\Query\\Toggle::setColumns:0' => 
        array (
          0 => 'columns',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
);
