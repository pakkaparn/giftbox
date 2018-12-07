<?php

namespace Test;

use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

trait RequestMockupTrait
{
    protected $app;

    public function __call($method, $args)
    {
        if (in_array(strtolower($method), ['get', 'post', 'put', 'patch', 'delete', 'options'])) {
            return $this->request(strtoupper($method), ...$args);
        }

        return parent::__call($method, $args);
    }

    protected function process(Request $request, Response $response): Response
    {
        return $this->app->process($request, $response);
    }

    protected function request(string $method, string $path, array $data = []): Request
    {
        $method = strtoupper($method);

        $request = Request::createFromEnvironment(Environment::mock([
            'REQUEST_METHOD' => strtoupper($method),
            'REQUEST_URI' => $path,
            'QUERY_STRING' => ($method == 'GET') ? http_build_query($data) : '',
        ]));

        $request = $request->withHeader('Content-Type', 'application/json');

        if ($method == 'POST') {
            $request->getBody()->write(json_encode($data));
        }

        return $request;
    }
}
