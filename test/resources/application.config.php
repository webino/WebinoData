<?php
return array(
    'modules' => array(
        'Application',
        'WebinoData',
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'config_static_paths'    => array(
            __DIR__ . '/../../test/resources/config.local.php',
        ),
        'module_paths' => array(
            'WebinoData' => __DIR__ . '/../..',
            './module',
            './vendor',
        ),
    ),
);
