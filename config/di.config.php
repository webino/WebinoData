<?php

namespace WebinoData;

return [
    'definition' => [
        'compiler' => [
            __DIR__ . '/../data/di/definition.php',
            __DIR__ . '/../data/di/DataService.definition.php',
        ],
    ],
    'instance' => [
        'alias' => [
            'WebinoDataRelations'     => 'WebinoData\DataPlugin\Relations',
            'WebinoDataDateTimeStamp' => 'WebinoData\DataPlugin\DateTimeStamp',
        ],
        'WebinoDataRelations' => [
            'parameters' => [
                'adapter' => 'Zend\Db\Adapter\Adapter',
            ],
        ],
        'WebinoData\DataPlugin\Order' => [
            'parameters' => [
                'adapter' => 'Zend\Db\Adapter\Adapter',
            ],
        ],
        'Zend\InputFilter\Factory' => [
            'injections' => [
                'Zend\Filter\FilterChain',
                'Zend\Validator\ValidatorChain',
            ],
        ],
        'Zend\Filter\FilterChain' => [
            'injections' => [
                'FilterManager',
            ],
        ],
        'Zend\Validator\ValidatorChain' => [
            'injections' => [
                'ValidatorManager',
            ],
        ],
    ],
];