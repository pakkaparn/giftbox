<?php

require_once __DIR__ . '/../vendor/autoload.php';

$env = new \Dotenv\Dotenv(__DIR__ . '/../');
$env->load();

if (getenv('TIMEZONE')) {
    date_default_timezone_set(getenv('TIMEZONE'));
}

$app = new Bootstrap\App([
    'name' => 'site',
]);

$app->run();
