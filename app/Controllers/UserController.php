<?php

declare(strict_types=1);
namespace Mini\Controllers;
use Mini\Core\Controller;
use Mini\Models\User;

final class UserController extends Controller {

    public function showCreateUserForm(): void{
        // Affiche le formulaire de création d'utilisateur
        $this->render('home/create-user', params: [
            'title' => 'Créer un utilisateur'
        ]);
    }
    public function showLoginUserform(): void{
        $this->render('home/login-user', params:[
            'title' => 'Connectez à un compte'
        ]);
    }
    public function showLogoutUserForm(): void{
        $this->render('home/logout-user', parmams:[
            'title' => 'Se deconnecter à un compte'
        ]);
    }
    public function showProfileUserForm(): void{
        $this->render('profile/user-profile', params:[
            'title'=> 'Informations de vos profils'
        ]);
    }

    public function createUser(): void{
        // Définit le header Content-Type pour indiquer que la réponse est du JSON
        header('Content-Type: application/json; charset=utf-8');
        
        // Vérifie que la méthode HTTP est POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Méthode non autorisée. Utilisez POST.'], JSON_PRETTY_PRINT);
            return;
        }
        
        // Récupère les données JSON du body de la requête
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Si pas de JSON, essaie de récupérer depuis $_POST
        if ($input === null) {
            $input = $_POST;
        }
        
        // Valide les données requises
        if (empty($input['nom']) || empty($input['email']) || empty($input['password']) || empty($input['confirmedpassword'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Les champs "nom", "email" et "mot de passe" sont requis.'], JSON_PRETTY_PRINT);
            return;
        }
        
        // Valide le format de l'email
        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => 'Format d\'email invalide.'], JSON_PRETTY_PRINT);
            return;
        }

        // Verifie si le mot de passe est identique et hash le mot de passe
        if ($input['password'] !== $input['confirmedpassword']){
            http_response_code(400);
            echo json_encode(['error' => 'Mot de passe et mot de passe confirmé sont différents'], JSON_PRETTY_PRINT);
            return;
        } else {
            $mdpClient = $input['password'];
            $mdphash = password_hash($mdpClient, PASSWORD_DEFAULT);
        }
        
        // Crée une nouvelle instance User
        $user = new User();
        $user->setNom($input['nom']);
        $user->setEmail($input['email']);
        $user->setMdp($mdphash);
        
        // Sauvegarde l'utilisateur
        if ($user->save()) {
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Utilisateur créé avec succès.',
                'user' => [
                    'nom' => $user->getnom(),
                    'email' => $user->getEmail(),
                    'password' => $user->getMdp()
                ]
            ], JSON_PRETTY_PRINT);
            exit;

        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la création de l\'utilisateur.'], JSON_PRETTY_PRINT);
            return;
        }
    }
    public function loginUser(): void{
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

        $user = User::findByEmail($input['loginEmail']); 

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
    public function LogoutUser(): void{

        header('Content-Type: application/json; charset=utf-8');

        session_unset();
        session_destroy();

        header('Location: /');

    }    
    public function ProfileUser(): void{

        header('Content-Type: application/json; charset=utf-8');

        if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true){
            $user_id = $_SESSION['user_id'];
            $username = $_SESSION['username'];
            echo json_encode([
                'user' => [
                    'user_id' => $user_id,
                    'username' => $username
                ]
            ], JSON_PRETTY_PRINT);
            exit;
        }else{
            http_response_code(400);
            echo json_encode(['error' => "Veuillez vous connecter"], JSON_PRETTY_PRINT);
            return;
        }
    }
}

?>
