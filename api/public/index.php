<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

chdir(dirname(__DIR__));
require __DIR__ . '/../vendor/autoload.php';

$config = require 'config/config.php';

$builder = new ContainerBuilder();
$builder->addDefinitions($config);
$container = $builder->build();

$app = AppFactory::createFromContainer($container);
(require 'config/routes.php')($app);

$app->run();