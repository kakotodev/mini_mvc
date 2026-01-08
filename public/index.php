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
    ['GET', '/users/profile', [Mini\Controllers\UserController::class, "showProfileUserForm"]],
    ['GET', '/users/profile', [Mini\Controllers\UserController::class, "ProfileUser"]],
    
    ['GET', '/users/historique', [Mini\Controllers\HistoriqueAchatController::class, "showHistory"]],

    // Panier

    ['GET', '/users/panier', [Mini\Controllers\PanierController::class, "showPanierUser"]],
    ['POST', '/computers', [Mini\Controllers\PanierController::class, "addPanierComputerProducts"]],
    ['POST', '/users/panier', [Mini\Controllers\PanierController::class, "removePanierComputerProducts"]],
    ['POST', '/users/panier/checkout', [Mini\Controllers\PanierController::class, "checkout"]],


    // Admin
    ['GET', '/admin/dashboard', [Mini\Controllers\AdminController::class, 'dashboard']],
    ['POST', '/admin/products/add', [Mini\Controllers\AdminController::class, 'createProduct']],
    ['POST', '/admin/products/update', [Mini\Controllers\AdminController::class, 'updateProduct']],

    // Autres
    ['GET', '/products', [Mini\Controllers\ProductController::class, 'listProducts']],
    ['GET', '/products/create', [Mini\Controllers\ProductController::class, 'showCreateProductForm']],

    ['POST', '/products', [Mini\Controllers\ProductController::class, 'createProduct']],
    ['GET', '/computers', [Mini\Controllers\ComputerProductController::class, "listComputerProducts"]],    
];
// Bootstrap du router
$router = new Router($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);