<?php

use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

require_once __DIR__ . '/../vendor/autoload.php';

$setting = require __DIR__ . '/../config/database.php';

$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => __DIR__ . '/db.sqlite3',
]);
$capsule->setEventDispatcher(new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container));
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['database'] = function ($container) use ($capsule) {
    return $capsule;
};

$app = new PhinxApplication();
$app->setAutoExit(false);
$app->run(new StringInput('migrate -e test'), new NullOutput());
