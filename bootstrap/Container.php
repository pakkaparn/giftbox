<?php

namespace Bootstrap;

use Slim\App;

class Container implements InjectionInterface
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function inject()
    {
        $container = $this->app->getContainer();
        $name = $container->name;

        $list = require_once __DIR__ . '/../config/container.php';

        foreach (['base', $name, 'debug'] as $section) {
            if (!isset($list[$section])) {
                continue;
            }

            foreach ($list[$section] as $key => $class) {
                $class = new $class;
                $container[$key] = $class();
            }
        }
    }
}
