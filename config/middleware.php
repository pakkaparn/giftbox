<?php

return [
    'base' => [
        (new Middlewares\TrailingSlash(false))->redirect(),
    ],

    'debug' => [
        new Middlewares\Whoops,
    ],
];
