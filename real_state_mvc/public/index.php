<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\PropController;

$router = new Router();

$router->get('/admin', [PropController::class, 'index']);
$router->get('/properties/create', [PropController::class, 'create']);
$router->post('/properties/create', [PropController::class, 'create']);
$router->get('/properties/update', [PropController::class, 'update']);
$router->post('/properties/update', [PropController::class, 'update']);
$router->post('/properties/delete', [PropController::class, 'delete']);

$router->checkRoute();