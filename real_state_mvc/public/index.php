<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropController;
use Controllers\SellerController;

$router = new Router();

// Properties
$router->get('/admin', [PropController::class, 'index']);
$router->get('/properties/create', [PropController::class, 'create']);
$router->post('/properties/create', [PropController::class, 'create']);
$router->get('/properties/update', [PropController::class, 'update']);
$router->post('/properties/update', [PropController::class, 'update']);
$router->post('/properties/delete', [PropController::class, 'delete']);

// Sellers
$router->get('/sellers/create', [SellerController::class, 'create']);
$router->post('/sellers/create', [SellerController::class, 'create']);
$router->get('/sellers/update', [SellerController::class, 'update']);
$router->post('/sellers/update', [SellerController::class, 'update']);
$router->post('/sellers/delete', [SellerController::class, 'delete']);

$router->checkRoute();