<?php

namespace Bootstrap;

use Slim\Container;

interface InjectionInterface
{
    public function __invoke(Container $container);
}
