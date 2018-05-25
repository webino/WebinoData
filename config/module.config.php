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

use WebinoData\Debugger\DbPanel;

// TODO remove, BC support
class_alias(Select::class, 'WebinoData\DataSelect');
class_alias(Store\AbstractStore::class, 'WebinoData\AbstractDataService');
class_alias(Store::class, 'WebinoData\DataService');
class_alias(Event\DataEvent::class, 'WebinoData\DataEvent');
class_alias(Paginator\AbstractPaginatorSelect::class, 'WebinoData\Paginator\Adapter\AbstractWebinoDataSelect');
class_alias(Paginator\PaginatorSelect::class, 'WebinoData\Paginator\Adapter\WebinoDataSelect');
class_alias(Plugin\OrderInterface::class, 'WebinoData\DataPlugin\OrderInterface');
class_alias(Plugin\AutoValue::class, 'WebinoData\DataPlugin\AutoValue');
class_alias(Plugin\OptionsInterface::class, 'WebinoData\DataPlugin\ConfigurableInterface');
class_alias(Plugin\CacheInvalidator::class, 'WebinoData\DataPlugin\CacheInvalidator');
class_alias(Plugin\DateTimeStamp::class, 'WebinoData\DataPlugin\DateTimeStamp');
class_alias(Plugin\Order::class, 'WebinoData\DataPlugin\Order');
class_alias(Plugin\Relations::class, 'WebinoData\DataPlugin\Relations');

return [
    // TODO remove deprecated DI config, use factories instead
    'di' => include __DIR__ . '/di.config.php',

    'caches' => [
        'WebinoDataCache' => [
            'adapter' => [
                'name' => 'filesystem',
                'options' => [
                    'namespace'       => 'webinodata',
                    'cache_dir'       => 'data/cache',
                    'dir_permission'  => false,
                    'file_permission' => false,
                    'umask'           => 7,
                ],
            ],
            'plugins' => [
                ['name' => 'serializer'],
            ],
        ],
    ],
    'filters' => [
        'invokables' => [
            'DateTimeFormatter' => Filter\DateTimeFormatter::class,
        ]
    ],

    'service_manager' => [
        'invokables' => [
            DbPanel::class => DbPanel::class,
        ],
    ],

    'webino_debug' => [
        'bar_panels' => [
            'WebinoData:db' => DbPanel::class,
        ],
    ],
];
