<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\ComputerProduct;
use Mini\Models\Panier;

final class PanierController extends Controller {

    public function showPanierUser(): void {
        if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true){
            $paniers = Panier::showPanierByIDUser($_SESSION['user_id']);
            $products = ComputerProduct::getAll();

            $this->render('panier/user-panier', params: [
                'title' => "Panier actuelle de l'utilisateur",
                'paniers' => $paniers,
            ]);            
        }else{
                $this->render('panier/user-panier', params: [
                'title' => "Panier actuelle de l'utilisateur",
            
            ]);         
        }
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
        $quantity = $input['quantity'];
        
        $userid = $_SESSION['user_id'];

        if (empty($productid) || empty($userid) || empty($quantity)){
            http_response_code(400);
            echo json_encode(['error' => 'productid, userid et quantity sont vides'], JSON_PRETTY_PRINT);
            return;
        }

        $panier = new Panier();
        $panier -> setUtilisateurID($userid);
        $panier -> setProduitID($productid);
        $panier -> setQuantity($quantity);
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

    public function removePanierComputerProducts(): void {
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users/panier');
            return;
        }

        if (empty($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] === false){
            header('Location: /users/login');
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        if($input === null) {
            $input = $_POST;
        }

        // In the view, the input name is 'id_ordinateur' but it contains the 'panier.id'
        $panierid = $input['id_ordinateur'] ?? null; 
        $userid = $_SESSION['user_id'];

        if (empty($panierid) || empty($userid)){
            header('Location: /users/panier');
            return;
        }

        if(Panier::abandon((int)$userid, (int)$panierid)) {
            header('Location: /users/panier');
        } else {
            header('Location: /users/panier?error=delete_failed');
        }
    }

    public function checkout(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users/panier');
            return;
        }

        if (empty($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] === false){
            header('Location: /users/login');
            return;
        }

        $userId = $_SESSION['user_id'];
        $activeItems = Panier::showPanierByIDUser($userId);

        if (empty($activeItems)) {
            header('Location: /users/panier?error=empty_cart');
            return;
        }

        $pdo = \Mini\Core\Database::getPDO();
        
        try {
            $pdo->beginTransaction();

            foreach ($activeItems as $item) {
                // 1. Add to HistoriqueAchat with Date
                $history = new \Mini\Models\HistoriqueAchat();
                $history->setUtilisateurID($userId);
                $history->setPanierId($item['id']);
                $history->setDateAchat(date('Y-m-d H:i:s'));
                
                if (!$history->save()) {
                    throw new \Exception("Failed to save history for item " . $item['id']);
                }

                // 2. Decrement Stock
                // Use the product ID (id_ordinateur) and quantity
                if (!\Mini\Models\ComputerProduct::decrementStock((int)$item['id_ordinateur'], (int)$item['quantity'])) {
                    throw new \Exception("Failed to update stock for product " . $item['id_ordinateur']); 
                }

                // 3. Update Status to 'Confirmé'
                $stmt = $pdo->prepare("UPDATE panier SET status = 'Confirmé' WHERE id = ?");
                $stmt->execute([$item['id']]);
            }

            $pdo->commit();
            header('Location: /users/historique?success=checkout_completed');

        } catch (\Exception $e) {
            $pdo->rollBack();
            // Log error in real app
            header('Location: /users/panier?error=checkout_failed');
        }
    }
}