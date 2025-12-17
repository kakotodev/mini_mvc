<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Panier;

final class PanierController extends Controller {

    public function showPanierUser(): void {
        
        

        if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true){
            $products = Panier::showPanierByIDUser($_SESSION['user_id']);

            $this->render('panier/user-panier', params: [
                'title' => "Panier actuelle de l'utilisateur",
                'products' => $products,
            ]);            
        }else{
                $this->render('panier/user-panier', params: [
                'title' => "Panier actuelle de l'utilisateur",
            
            ]);         
        }
    }
}