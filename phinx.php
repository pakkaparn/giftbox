<?php

require __DIR__ . '/vendor/autoload.php';

$env = new \Dotenv\Dotenv(__DIR__);
$env->load();

return [
    'paths' => [
        'migrations' => __DIR__ . '/db/migrations',
        'seeds' => __DIR__ . '/db/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'production',
        'production' => [
            'adapter' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_DATABASE'),
            'user' => getenv('DB_USERNAME'),
            'pass' => getenv('DB_PASSWORD'),
            'port' => getenv('DB_PORT'),
            'charset' => getenv('DB_CHARSET'),
            'collation' => getenv('DB_COLLATION'),
            'table_prefix' => getenv('DB_PREFIX'),
        ],
        'test' => [
            'adapter' => 'sqlite',
            'memory' => true,
            'charset' => getenv('DB_CHARSET'),
            'collation' => getenv('DB_COLLATION'),
            'table_prefix' => getenv('DB_PREFIX'),
        ],
    ],
    'version_order' => 'creation',
];
