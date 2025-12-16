<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\ComputerProduct;
use Mini\Models\Panier;

final class ComputerProductController extends Controller {

    public function listComputerProducts(): void {
        $computerproducts = ComputerProduct::getAll();

        $this->render('computers/list-computerproducts', params: [
            'title' => 'Liste des Ordinateurs disponibles',
            'computerproducts' => $computerproducts
        ]);
    }

    public function addPanierComputerProducts(): void {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /computers');
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if($input === null) {
            $input = $_POST;
        }

        if (empty($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === false){
            http_response_code(400);
            echo json_encode(['error' => 'Veuillez vous connecter à votre compte.'], JSON_PRETTY_PRINT);
            return;
        }

        $productid = $input['id_ordinateur'];
        $userid = $_SESSION['user_id'];

        if (empty($productid) || empty($userid)){
            http_response_code(400);
            echo json_encode(['error' => 'productid et userid sont vide'], JSON_PRETTY_PRINT);
            return;
        }

        $panier = new Panier();
        $panier -> setUtilisateurID($userid);
        $panier -> setProduitID($productid);
        $panier -> setStatus('En cours');
    
        if($panier->save()) {
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Produit ajouté à votre panier',
                'user' => [
                    'UtilisateurID' => $panier->getUtilisateurID(),
                    'ProduitID' => $panier->getProduitID(),
                    'Status' => $panier->getStatus()
                ]
            ], JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erreur lors de l'ajout du produit dans votre panier."], JSON_PRETTY_PRINT);
        }
    }
}