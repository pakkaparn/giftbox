<?php
namespace App\Containers;

use Bootstrap\ContainerInterface;
use Closure;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

class TwigView implements ContainerInterface
{
    public function __invoke(): Closure
    {
        return function ($container) {
            $view = new Twig(__DIR__ . '/../Views', [
                'cache' => __DIR__ . '/../../storage/cache/templates',
            ]);

            $router = $container->get('router');
            $uri = Uri::createFromEnvironment(new Environment($_SERVER));
            $view->addExtension(new TwigExtension($router, $uri));

            return $view;
        };
    }
}
