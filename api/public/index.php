<?php

use Slim\Factory\AppFactory;
use App\Http\Action;

require __DIR__ . '/../vendor/autoload.php';

//===========================
$config = [
    Action\HomeAction::class => function () {
        return new Action\HomeAction();
    },
    Action\TestAction::class => function () {
        return new Action\TestAction();
    },
];
//===========================

$app = AppFactory::create();

$app->get('/',
    $config[Action\HomeAction::class]()
);

$app->get('/test',
    $config[Action\TestAction::class]()
);

$app->run();