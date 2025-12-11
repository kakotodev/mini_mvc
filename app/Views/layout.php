<!doctype html>
<!-- Définit la langue du document -->
<html lang="fr">
<!-- En-tête du document HTML -->
<head>
    <!-- Déclare l'encodage des caractères -->
    <meta charset="utf-8">
    <!-- Configure le viewport pour les appareils mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Définit le titre de la page avec échappement -->
    <title><?= isset($title) ? htmlspecialchars($title) : 'App' ?></title>
    <link rel="stylesheet" href="/styles/header.css">
</head>
<!-- Corps du document -->
<body>
<?php
// Détermine la page active pour la navigation
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$isHome = ($currentPath === '/');
$isProducts = ($currentPath === '/products');
$isProductsCreate = ($currentPath === '/products/create');
$isUsersCreate = ($currentPath === '/users/create');

?>
<!-- En-tête de la page -->
<header style="background-color: #343a40; color: white; padding: 15px 0; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <?php
        require_once __DIR__ . '/templates/header.php'
    ?>
</header>
<!-- Zone de contenu principal -->
<main>
    <!-- Insère le contenu rendu de la vue -->
    <?= $content ?>
    
</main>
<!-- Fin du corps de la page -->
</body>
<!-- Fin du document HTML -->
</html>

