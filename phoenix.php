<?php


return [
    'migration_dirs' => [
        'first' => __DIR__ . '/migrations'
    ],
    'environments' => [
        'local' => [
            'adapter' => 'mysql',
            'host' => '127.0.0.1',
            'port' => 8889, // optional
            'username' => 'root',
            'password' => 'root',
            'db_name' => 'slim_project',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci', // optional, if not set default collation for utf8mb4 is used
        ],
    ],
    'default_environment' => 'local',
    'log_table_name' => 'phoenix_log',
];