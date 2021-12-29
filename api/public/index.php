<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use App\Http\Action;

chdir(dirname(__DIR__));
require __DIR__ . '/../vendor/autoload.php';

$config = require 'config/config.php';

$builder = new ContainerBuilder();
$builder->addDefinitions($config);
$container = $builder->build();

$app = AppFactory::createFromContainer($container);

$app->get('/', Action\HomeAction::class);
$app->get('/test', Action\TestAction::class);

$app->run();