<?php

declare(strict_types=1);

namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Models\Panier;

final class PanierController extends Controller {

    public function showPanierUser(): void {

        die('Le controleur est bien mort');

        $panier = Panier::selectAllByID($_SESSION['user_id']);
        echo var_dump($panier);
        $this->render('profile/user-panier', params: [
            'title' => "Panier actuelle de l'utilisateur",
            'panier' => $panier,
            'test' => 'test'
        ]);
    }
}