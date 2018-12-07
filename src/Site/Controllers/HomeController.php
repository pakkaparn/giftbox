<?php

namespace App\Site\Controllers;

class HomeController extends BaseController
{
    public function index($request, $response, $args)
    {
        return $this->view->render($response, 'home.twig');
    }
}
