<?php

return array(
    'di' => array(
        'definition' => array(
            'compiler' => array(
                __DIR__ . '/../data/di/definition.php',
            ),
            'class' => array(
                'WebinoData\DataService' => array(
                    'methods' => array(
                        'setHasOneService' => array(
                            'name' => array('type' => false),
                            'serviceName' => array('type' => false),
                            'options' => array('type' => false, 'default' => array()),
                        ),
                        'setHasManyService' => array(
                            'name' => array('type' => false),
                            'serviceName' => array('type' => false),
                            'options' => array('type' => false, 'default' => array()),
                        ),
                    ),
                ),
            ),
        ),
        'instance' => array(
            'alias' => array(
                'WebinoDataRelations' => 'WebinoData\DataPlugin\Relations',
                'WebinoDataDateTimeStamp' => 'WebinoData\DataPlugin\DateTimeStamp',
            ),
            'WebinoDataRelations' => array(
                'parameters' => array(
                    'adapter' => 'Zend\Db\Adapter\Adapter',
                ),
            ),
            'WebinoData\DataPlugin\Order' => array(
                'parameters' => array(
                    'adapter' => 'Zend\Db\Adapter\Adapter',
                ),
            ),
            'Zend\InputFilter\Factory' => array(
                'injections' => array(
                    'Zend\Filter\FilterChain',
                    'Zend\Validator\ValidatorChain',
                ),
            ),
            'Zend\Filter\FilterChain' => array(
                'injections' => array(
                    'FilterManager',
                ),
            ),
            'Zend\Validator\ValidatorChain' => array(
                'injections' => array(
                    'ValidatorManager',
                ),
            ),
        ),
    ),
);
