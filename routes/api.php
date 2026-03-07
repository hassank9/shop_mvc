<?php
declare(strict_types=1);

use App\Helpers\Response;
use App\Controllers\Api\ProductApiController;
use App\Controllers\Api\CartApiController;

use App\Controllers\AuthController;

$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);

$router->post('/logout', [AuthController::class, 'logout']);

/** @var \App\Helpers\Router $router */

$router->get('/api/ping', function () {
    Response::json(['ok' => true, 'message' => 'pong', 'ts' => time()]);
});

$router->get('/api/orders/items', [\App\Controllers\OrderController::class, 'itemsJson']);

$router->get('/api/products/search', [ProductApiController::class, 'search']);

$router->get('/api/products/browse', [ProductApiController::class, 'browse']);

// Cart API
$router->get('/api/cart', [CartApiController::class, 'get']);
$router->post('/api/cart/add', [CartApiController::class, 'add']);
$router->post('/api/cart/update', [CartApiController::class, 'update']);
$router->post('/api/cart/clear', [CartApiController::class, 'clear']);