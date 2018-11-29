<?php

$app->get('/', function ($request, $response, $args) {
    return 'Hello World';
});

$app->get('/about', function ($request, $response, $args) {
    return 'About';
});
