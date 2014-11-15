<?php

namespace WebinoData;

return [
    'di' => include __DIR__ . '/di.config.php',
    'caches' => [
        'WebinoDataCache' => [
            'adapter' => [
                'name' => 'filesystem',
                'options' => [
                    'namespace'      => 'webinodata',
                    'cacheDir'       => 'data/cache',
                    'dirPermission'  => 02770,
                    'filePermission' => 02770,
                ],
            ],
            'plugins' => [
                ['name' => 'serializer'],
            ],
        ],
    ],
];
