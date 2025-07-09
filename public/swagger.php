<?php
require __DIR__ . '/../vendor/autoload.php';
header('Content-Type: application/json');
$openapi = \OpenApi\Generator::scan([dirname(__DIR__) . '/src']);
echo $openapi->toJson();
