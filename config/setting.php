<?php

return [
    'displayErrorDetails' => (getenv('ENVIRONMENT') === 'development' ? true : false),
    'determineRouteBeforeAppMiddleware' => true,
    'addContentLengthHeader' => false,
    'debug' => (getenv('ENVIRONMENT') === 'development' ? true : false),
    'whoops.editor' => 'sublime',
];
