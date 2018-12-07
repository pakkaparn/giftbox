<?php
use App\Api\v1;

$app->group('/v1', function () {
    $this->get('', function ($req, $res, $args) {
        return $res->withStatus(204);
    });

    $this->group('/users', function () {
        $this->get('', v1\Controllers\WcmsUserController::class . ':index');
    });
});
