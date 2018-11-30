<?php

namespace App\Containers;

use Bootstrap\ContainerInterface;
use Closure;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;

class Logger implements ContainerInterface
{
    public function __invoke(): Closure
    {
        return function ($container) {
            $logger = new Monolog('logger');
            $file_handler = new StreamHandler(
                __DIR__ . '/../../storage/logs/' . date('Y-m-d') . '.log'
            );
            $logger->pushHandler($file_handler);

            return $logger;
        };
    }
}
