<?php

namespace WebinoData;

use WebinoData\Debugger\DbPanel;

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
