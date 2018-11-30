<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index($request, $response, $args)
    {
        return 'Hello World';
    }
}
