<?php

$app->get('/', App\Controllers\HomeController::class . ':index');

$app->get('/about', function ($request, $response, $args) {
    return 'About';
});
