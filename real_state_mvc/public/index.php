<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropController;
use Controllers\SellerController;
use Controllers\PageController;

$router = new Router();

/** PRIVATE ZONE **/

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

/** END OF PRIVATE ZONE **/

// Public-facing section: handles what users can see
$router->get('/', [PageController::class, 'index']);
$router->get('/about-us', [PageController::class, 'aboutUs']);
$router->get('/properties', [PageController::class, 'properties']);
$router->get('/property', [PageController::class, 'property']);
$router->get('/blog', [PageController::class, 'blog']);
$router->get('/entry', [PageController::class, 'entry']);
$router->get('/contact', [PageController::class, 'contact']);
$router->post('/contact', [PageController::class, 'contact']);

$router->checkRoute();