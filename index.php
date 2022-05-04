<?php

use App\App;
use App\Controllers\Http\RedisController;
use App\Controllers\Http\RedisCliController;
use App\Router\Router;
use Lib\Http\Request;

require __DIR__ . '/vendor/autoload.php';

$app = new App();
$request = new Request();
$router = $app->getRouter();

$router->get('/api/redis', [RedisController::class, 'all']);
$router->delete('/api/redis/{key}', [RedisController::class, 'delete']);

$app->handle($request);
