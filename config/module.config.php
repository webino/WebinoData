<?php

namespace WebinoData;

return [
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
];
