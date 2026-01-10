<?php
declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\ComputerProduct;

class AdminController extends Controller {

    private function checkAdminAccess() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['is_logged_in']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
            header('Location: /');
            exit;
        }
    }

    public function dashboard(): void {
        $this->checkAdminAccess();
        $products = ComputerProduct::getAll();
        $this->render('admin/dashboard', params: [
            'title' => 'Tableau de bord Admin',
            'products' => $products
        ]);
    }

    public function createProduct(): void {
        $this->checkAdminAccess();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
             $input = $_POST;
        }

        if (empty($input['nom']) || empty($input['prix']) || empty($input['stock'])) {
             http_response_code(400);
             echo json_encode(['error' => 'Missing required fields']);
             return;
        }

        $product = new ComputerProduct();
        $product->setNom($input['nom']);
        $product->setPrix($input['prix']);
        $product->setDescription($input['description'] ?? '');
        $product->setComposants($input['composants'] ?? '');
        $product->setComposants($input['composants'] ?? '');
        $product->setStock((int)$input['stock']);
        $product->setUrlImg($input['url_img'] ?? '');
        $product->setDisponible($input['disponible'] ?? 'disponible');

        if ($product->save()) {
            http_response_code(201);
            echo json_encode(['success' => true, 'message' => 'Produit ajouté']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to save product']);
        }
    }

    public function updateProduct(): void {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
             return;
        }
        $input = json_decode(file_get_contents('php://input'), true);

        if (empty($input['id'])) {
             http_response_code(400);
             echo json_encode(['error' => 'Missing ID parameter']);
             return;
        }

        $product = new ComputerProduct();
        $product->setIdOrdinateur((int)$input['id']);
        $product->setNom($input['nom']);
        $product->setPrix((float)$input['prix']);
        $product->setDescription($input['description'] ?? '');
        $product->setComposants($input['composants'] ?? '');
        $product->setStock((int)$input['stock']);
        $product->setUrlImg($input['url_img'] ?? '');
        $product->setDisponible($input['disponible'] ?? 'disponible');

        if ($product->update()) {
             echo json_encode(['success' => true]);
        } else {
             http_response_code(500);
             echo json_encode(['error' => 'Failed to update']);
        }
    }
}
