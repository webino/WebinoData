<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData;

/**
 * WebinoData application test config
 */
return [
    'modules' => [
        'WebinoDev',
        'WebinoDebug',
        'Application',
        __NAMESPACE__,
    ],
    'webino_debug' => [
        // Development mode
        'enabled' => 'cli' !== PHP_SAPI,
        'mode'    => false,
        'bar'     => true,
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
        'config_static_paths' => [
            __DIR__ . '/module.config.php',
            // TODO examples config
            //__DIR__ . '/../../../examples/config/module.config.php',
        ],
        'module_paths' => [
            __NAMESPACE__ => __DIR__ . '/../../src',
            'module',
            'vendor',
        ],
    ],
];
