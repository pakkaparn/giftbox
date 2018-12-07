<?php

namespace App\Api\v1\Controllers;

class WcmsUserController
{
    public function index($request, $response, $args)
    {
        return $response->withJson([['id' => 1]]);
    }
}
