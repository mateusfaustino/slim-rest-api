<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;
// use Slim\Psr7\Request;
// use Slim\Psr7\Response;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use Slim\App;

require dirname(__DIR__).'/vendor/autoload.php';

$app = AppFactory::create();

$app->get('/api/products', function(Request $request, Response $response){
    $response->getBody()->write("Hello World!");

    return $response;   
});

$app->run();