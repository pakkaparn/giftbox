<?php

namespace Bootstrap;

use Slim\App;

interface InjectionInterface
{
    public function __construct(App $app);
    public function inject();
}
