<?php

declare(strict_types=1);

use App\Http\Action;
use Slim\App;

return function (App $app) {
    $app->get('/', Action\HomeAction::class);
    $app->get('/test', Action\TestAction::class);
};