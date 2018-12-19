<?php

namespace App\Site\Controllers;

use Interop\Container\ContainerInterface;

class BaseController
{
    protected $container;
    protected $view;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->view = $container->view;
    }
}
