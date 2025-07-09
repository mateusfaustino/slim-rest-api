<?php

declare(strict_types=1);

use DI\Container;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$container = new Container();
$dependencies = require dirname(__DIR__) . '/src/Infrastructure/Framework/Config/dependencies.php';
$dependencies($container);

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addBodyParsingMiddleware();
(require dirname(__DIR__) . '/src/Presentation/Http/Routes.php')($app);

$app->run();
