<?php

declare(strict_types=1);
// error_reporting(0);
// session_start();

require_once __DIR__ . '/vendor/autoload.php';

use App\Router\Router;
use App\Controller\StaticController;

$router = new Router();

$router->get('/', [StaticController::class, 'index']);
$router->get('orders/{id}', [StaticController::class, 'index']);
