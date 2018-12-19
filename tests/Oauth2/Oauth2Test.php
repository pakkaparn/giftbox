<?php

namespace Test\Api\v1\Middlewares;

use App\Oauth2\Oauth2;
use Bootstrap\App;
use OAuth2\Server;
use OAuth2\Storage\Pdo;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Views\Twig;
use Test\RequestMockupTrait;

class Oauth2Test extends TestCase
{
    use RequestMockupTrait;

    public function setUp()
    {
        $this->app = new App([
            'name' => 'api',
        ]);
    }

    public function testComponent()
    {
        $oauth = new Oauth2();

        $this->assertInstanceOf(Pdo::class, $oauth->getStorage());
        $this->assertInstanceOf(Server::class, $oauth->getServer());
        $this->assertInstanceOf(Twig::class, $oauth->getView());
    }

    public function testAuthorize()
    {
        $request = $this->get('/');
        $response = new Response;

        $oauth = new Oauth2();
        $authorize = $oauth->getAuthorize();

        $this->assertInstanceOf(ResponseInterface::class, $authorize($request, $response));
    }

    public function testReceiver()
    {
        $request = $this->get('/');
        $response = new Response;

        $oauth = new Oauth2();
        $receiver = $oauth->getReceiver();

        $this->assertInstanceOf(ResponseInterface::class, $receiver($request, $response));
    }

    public function testMiddleware()
    {
        $request = $this->get('/');
        $response = new Response;

        $oauth = new Oauth2();

        $middleware = $oauth->getMiddleware($this->app->getContainer());
        $this->assertInstanceOf(
            ResponseInterface::class,
            $middleware($request, $response, function () {})
        );
    }
}
