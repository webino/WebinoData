<?php

namespace WebinoData;

return [
    'di' => include __DIR__ . '/di.config.php',

    'caches' => [
        'WebinoDataCache' => [
            'adapter' => [
                'name' => 'filesystem',
                'options' => [
                    'namespace'      => 'webinodata_cache',
                    'cacheDir'       => 'data/cache',
                    'dirPermission'  => false,
                    'filePermission' => false,
                    'umask'          => 7,
                ],
            ],
            'plugins' => [
                ['name' => 'serializer'],
            ],
        ],
    ],
];
