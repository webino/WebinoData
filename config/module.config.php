<?php

return array(
    'di' => array(
        'definition' => array(
            'compiler' => array(
                __DIR__ . '/../data/di/definition.php',
            ),
        ),
        'instance' => array(
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
