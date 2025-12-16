<?php

declare(strict_types=1);

require dirname(path: __DIR__) . '/vendor/autoload.php';

session_start();

use Mini\Core\Router;

// Table des routes minimaliste
$routes = [

    ['GET', '/', [Mini\Controllers\HomeController::class, 'index']],
    ['GET', '/users', [Mini\Controllers\HomeController::class, 'users']],
    ['POST', '/users', [Mini\Controllers\UserCreateController::class, 'createUser']],
    ['POST', '/users/login', [Mini\Controllers\UserLoginController::class, 'loginUser']],
    ['GET', '/users/login', [Mini\Controllers\UserLoginController::class, 'showLoginUserForm']],
    ['GET', '/users/create', [Mini\Controllers\UserCreateController::class, 'showCreateUserForm']],
    ['GET', '/products', [Mini\Controllers\ProductController::class, 'listProducts']],
    ['GET', '/products/create', [Mini\Controllers\ProductController::class, 'showCreateProductForm']],
    ['POST', '/products', [Mini\Controllers\ProductController::class, 'createProduct']],
    ['GET', '/computers', [Mini\Controllers\ComputerProductController::class, "listComputerProducts"]],
    ['GET', '/users/logout', [Mini\Controllers\UserLogoutController::class, "logoutUser"]],
    ['GET', '/users/logout', [Mini\Controllers\UserLogoutController::class, "showLogoutUserForm"]],
    ['GET', '/users/profile', [Mini\Controllers\UserProfilController::class, "showProfileUserForm"]],
    ['GET', '/users/profile', [Mini\Controllers\UserProfilController::class, "ProfileUser"]]
];
// Bootstrap du router
$router = new Router($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);