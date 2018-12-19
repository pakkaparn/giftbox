<?php

namespace App\Oauth2;

use Chadicus\Slim\OAuth2\Middleware\Authorization;
use Chadicus\Slim\OAuth2\Routes\Authorize;
use Chadicus\Slim\OAuth2\Routes\ReceiveCode;
use Exception;
use OAuth2\GrantType;
use OAuth2\Server;
use OAuth2\Storage;
use OAuth2\Storage\AuthorizationCodeInterface;
use PDO;
use Psr\Container\ContainerInterface;
use Slim\Views\Twig;

class Oauth2
{
    protected $server;
    protected $storage;
    protected $view;
    protected $authorize;
    protected $receiver;
    protected $template = '/auth.twig';

    public function __construct()
    {
        $this->storage = $this->storage();
        $this->server = $this->server();
        $this->view = $this->view();
    }

    public function getAuthorize(): Authorize
    {
        return new Authorize($this->server, $this->view, $this->template);
    }

    public function getReceiver(): ReceiveCode
    {
        return new ReceiveCode($this->view, $this->template);
    }

    public function getMiddleware(ContainerInterface $container): Authorization
    {
        return new Authorization($this->server, $container);
    }

    public function getStorage(): AuthorizationCodeInterface
    {
        return $this->storage;
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    public function getView(): Twig
    {
        return $this->view;
    }

    protected function storage(): AuthorizationCodeInterface
    {
        $type = strtoupper(getenv('OAUTH2_STORAGE_TYPE'));

        switch ($type) {
            case 'PDO':
                return new Storage\Pdo($this->pdo());
            case 'REDIS':
                break;
            default:
                throw new Exception('OAUTH2_STORAGE_TYPE is not support', 500);
        }
    }

    protected function server(): Server
    {
        return new Server(
            $this->storage,
            [
                'access_lifetime' => 3600,
            ],
            [
                new GrantType\ClientCredentials($this->storage),
                new GrantType\AuthorizationCode($this->storage),
            ]
        );
    }

    protected function view(): Twig
    {
        return new Twig(__DIR__);
    }

    private function pdo(): PDO
    {
        switch (getenv('DB_DRIVER')) {
            case 'mysql':
                $connection = sprintf(
                    'mysql:host=%s;port=%s;dbname=%s;charset=%s;',
                    getenv('DB_HOST'),
                    getenv('DB_PORT') ?: 3306,
                    getenv('DB_DATABASE'),
                    getenv('DB_CHARSET')
                );

                $username = getenv('DB_USERNAME');
                $password = getenv('DB_PASSWORD');
                $options = [
                    PDO::MYSQL_ATTR_INIT_COMMAND => sprintf('COLLATE \'%s\'', getenv('DB_COLLATION')),
                ];
                break;
            case 'sqlite':
                $connection = sprintf(
                    'sqlite:%s',
                    getenv('DB_DATABASE')
                );
                break;
        }

        return new PDO($connection, $username ?? null, $password ?? null, $options ?? []);
    }
}
