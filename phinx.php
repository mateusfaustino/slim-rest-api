<?php

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds'      => '%%PHINX_CONFIG_DIR%%/database/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => 'db',
            'name' => 'app',
            'user' => 'root',
            'pass' => 'password',
            'port' => '3306',
            'charset' => 'utf8mb4',
        ],
    ],
];
