<?php

namespace Bootstrap;

use Bnf\Slim3Psr15\CallableResolver;

class App
{
    protected $app;

    public function __construct(array $_container = [])
    {
        $settings = require __DIR__ . '/../config/setting.php';

        $_container['settings'] = ($_container['settings'] ?? []) + $settings;

        $app = new \Slim\App($_container);

        $container = $app->getContainer();

        $container['callableResolver'] = function ($container) {
            return new CallableResolver($container);
        };

        (new Container($app))->inject();
        (new Middleware($app))->inject();

        $route = sprintf('%s/../routes/%s.php', __DIR__, $container->name ?? 'main');
        if (realpath($route)) {
            require $route;
        }

        $this->app = $app;
    }

    public function __call($name, $arguments)
    {
        return $this->app->{$name}(...$arguments);
    }

    public function getApp()
    {
        return $this->app;
    }
}
