<?php

namespace Bootstrap;

use Exception;
use Psr\Http\Server\MiddlewareInterface;
use Slim\App;

class Middleware implements InjectionInterface
{
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function inject()
    {
        $name = $this->app->getContainer()->name;

        $list = require_once __DIR__ . '/../config/middleware.php';

        foreach (['base', $name, 'debug'] as $key) {
            if (!isset($list[$key])) {
                continue;
            }

            foreach ($list[$key] as $middleware) {
                if (!is_object($middleware) && !class_exists($middleware)) {
                    throw new Exception(sprintf('%s is not exist', $middleware), 500);
                }

                $interfaces = class_implements($middleware);

                if (isset($interfaces[MiddlewareInterface::class])) {
                    $this->app->add($middleware);
                }
            }
        }
    }
}
