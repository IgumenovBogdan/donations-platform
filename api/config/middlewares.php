<?php

declare(strict_types=1);

use App\Http\Middleware\ExceptionHandler;
use App\Http\Middleware\TestMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(TestMiddleware::class);
    $app->add(ExceptionHandler::class);
};