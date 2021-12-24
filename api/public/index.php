<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Http\Action;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$action = function () {
    return new Action\HomeAction();
};

$app->get('/', $action());

$app->get('/test', function (Request $request, Response $response, $args) {
    $response->getBody()->write("<h1>This is a test page</h1>");
    return $response;
});

$app->run();