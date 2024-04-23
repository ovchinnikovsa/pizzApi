<?php

declare(strict_types=1);
// error_reporting(0);
// session_start();

require_once __DIR__ . '/vendor/autoload.php';

use App\Router\Router;
use App\Controller\StaticController;
use App\Controller\Order;

$router = new Router();

$router->get('', [StaticController::class, 'index']);
$router->post('orders', [Order::class, 'newOrder']);
$router->post('orders/{order_id}/items', [Order::class, 'addToOrder']);
$router->get('orders/{order_id}', [Order::class, 'getOrder']);
$router->post('orders/{order_id}/done', [Order::class, 'setOrderDone']);
$router->get('orders', [Order::class, 'getAllOrder']);
