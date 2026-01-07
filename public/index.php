<?php

declare(strict_types=1);

require dirname(path: __DIR__) . '/vendor/autoload.php';

session_start();

use Mini\Core\Router;

// Table des routes minimaliste
$routes = [

    // Accueil
    ['GET', '/', [Mini\Controllers\HomeController::class, 'index']],

    // Inscription, Connexion, Logout

    ['GET', '/users/login', [Mini\Controllers\UserController::class, 'showLoginUserForm']],
    ['POST', '/users/login', [Mini\Controllers\UserController::class, 'loginUser']],

    ['GET', '/users/create', [Mini\Controllers\UserController::class, 'showCreateUserForm']],
    ['POST', '/users/create', [Mini\Controllers\UserController::class, 'createUser']],

    ['GET', '/users/logout', [Mini\Controllers\UserController::class, "logoutUser"]],
    ['GET', '/users/logout', [Mini\Controllers\UserController::class, "showLogoutUserForm"]],
    
    ['GET', '/users/profile', [Mini\Controllers\UserController::class, "showProfileUserForm"]],
    ['GET', '/users/profile', [Mini\Controllers\UserController::class, "ProfileUser"]],

    // Panier

    ['GET', '/users/panier', [Mini\Controllers\PanierController::class, "showPanierUser"]],


    // Autres
    ['GET', '/products', [Mini\Controllers\ProductController::class, 'listProducts']],
    ['GET', '/products/create', [Mini\Controllers\ProductController::class, 'showCreateProductForm']],

    ['POST', '/products', [Mini\Controllers\ProductController::class, 'createProduct']],
    ['GET', '/computers', [Mini\Controllers\ComputerProductController::class, "listComputerProducts"]],

    ['POST', '/computers', [Mini\Controllers\ComputerProductController::class, "addPanierComputerProducts"]],
    
];
// Bootstrap du router
$router = new Router($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);