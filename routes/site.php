<?php

$app->get('/', App\Site\Controllers\HomeController::class . ':index');

$app->get('/about', function ($request, $response, $args) {
    return 'About';
});
