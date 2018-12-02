<?php

namespace App\Controllers;

class BaseController
{
    protected $container;
    protected $view;

    public function __construct($container)
    {
        $this->container = $container;
        $this->view = $container->view;
    }
}
