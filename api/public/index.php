<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


chdir(dirname(__DIR__));
require __DIR__ . '/../vendor/autoload.php';

$config = require 'config/config.php';

$builder = new ContainerBuilder();
$builder->addDefinitions($config);
$container = $builder->build();

$app = AppFactory::createFromContainer($container);

$app->add(function(Request $request, RequestHandler $handler) {
    $response = $handler->handle($request);
    echo PHP_EOL . ('This is middleware!') . PHP_EOL;
    return $response;
});

(require 'config/routes.php')($app);

$app->run();