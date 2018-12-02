<?php

namespace Test;

use Bootstrap\App;
use PHPUnit\Framework\TestCase;
use Slim\Http\Response;

class RouteTest extends TestCase
{
    use RequestMockupTrait;

    public function setUp()
    {
        $this->app = new App([
            'name' => 'site',
        ]);
    }

    public function testIndex()
    {
        $request = $this->get('/');
        $response = $this->process($request, new Response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testNotFound()
    {
        $request = $this->get('/404');
        $response = $this->process($request, new Response);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
