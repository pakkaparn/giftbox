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
        $name = $this->app->getContainer()->name;

        $list = require_once __DIR__ . '/../config/container.php';

        foreach (['base', $name, 'debug'] as $key) {
            if (!isset($list[$key])) {
                continue;
            }

            foreach ($list[$key] as $class) {
                $class = new $class;
                $class($this->app->getContainer());
            }
        }
    }
}
