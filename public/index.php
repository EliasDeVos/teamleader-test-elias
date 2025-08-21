<?php

use Slim\Factory\AppFactory;
use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

// Build PHP-DI Container
$containerBuilder = new ContainerBuilder();
(require __DIR__ . '/../app/dependencies.php')($containerBuilder);
$container = $containerBuilder->build();

// Set container to Slim App
AppFactory::setContainer($container);
$app = AppFactory::create();

(require __DIR__ . '/../app/routes.php')($app);

$app->run();
