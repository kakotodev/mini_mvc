<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\User;

final class UserLoginController extends Controller {

    public function showLoginUserform(): void{
        $this->render('home/login-user', params:[
            'title' => 'Connectez à un compte'
        ]);
    }

    private $userModel;

    public function __construct(){
        $this->userModel = new User();
    }

    public function loginUser(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Méthode non autorisée. Utilisez POST'], JSON_PRETTY_PRINT);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if($input === null) {
            $input = $_POST;
        }


        if (empty($input['loginEmail']) || empty($input['loginPassword'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Les champs "email" et "password" sont requis.'], JSON_PRETTY_PRINT);
            return;
        }

        if (!filter_var($input['loginEmail'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => "Format d'email invalide."], JSON_PRETTY_PRINT);
            return;
        }
        
        // Mise en place du login

        $user = $this->userModel->findByEmail($input['loginEmail']);

        if ($user && password_verify($input['loginPassword'], $user['mdp'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION ['username'] = $user['nom'];
            $_SESSION['is_logged_in'] = true;

            session_regenerate_id(true);

            echo json_encode([
                'success' => true,
                'message' => 'Connexion réussie.',
                'user' => [
                    'email' => $user['email']
                ]
            ], JSON_PRETTY_PRINT);
            exit;
        }
        else {
            http_response_code(400);
            echo json_encode(['error' => 'Le mot de passe n\'est pas bon']);
            return;
        }
    }
}

?>