<?php

declare(strict_types=1);

namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Models\Panier;

final class PanierController extends Controller {
    public function showPanierForm(): void {

        $panier = Panier::selectAllByID($_SESSION['user_id']);

        $this-render('profile/user-panier', params:[
        'title' => "Panier actuelle de l'utilisateur",
        'panier' => $panier
        ]);
    }
}