<?php

namespace App\Site\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HomeController extends BaseController
{
    public function index(Request $request, Response $response, $args): Response
    {
        return $this->view->render($response, 'home.twig');
    }
}
