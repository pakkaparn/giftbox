<?php

namespace Test\Routers;

use Bootstrap\App;
use PHPUnit\Framework\TestCase;
use Slim\Http\Response;
use Test\RequestMockupTrait;

class ApiTest extends TestCase
{
    use RequestMockupTrait;

    public function setUp()
    {
        $this->app = new App([
            'name' => 'api',
        ]);
    }

    public function testIndex()
    {
        $request = $this->get('/v1');
        $response = $this->process($request, new Response);
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testGetUsers()
    {
        $request = $this->get('/v1/users');
        $response = $this->process($request, new Response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(is_array(json_decode($response->getBody())));
    }

    public function testNotFound()
    {
        $request = $this->get('/v1/404');
        $response = $this->process($request, new Response);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
