<?php

// Active le mode strict pour la vérification des types
declare(strict_types=1);
// Déclare l'espace de noms pour ce contrôleur
namespace Mini\Controllers;
// Importe la classe de base Controller du noyau
use Mini\Core\Controller;
use Mini\Models\User;

// Déclare la classe finale HomeController qui hérite de Controller
final class HomeController extends Controller
{
    // Déclare la méthode d'action par défaut qui ne retourne rien
    public function index(): void
    {
        // Appelle le moteur de rendu avec la vue et ses paramètres
        $this->render('home/index', params: [
            // Définit le titre transmis à la vue
            'title' => 'Mini MVC',
            'prenom' => 'Toto',
            'prenom2' => 'Tata',
            'test' => '123'
        ]);
    }

    public function users(): void
    {
        // Récupère tous les utilisateurs
        $users = User::getAll();
        
        // Définit le header Content-Type pour indiquer que la réponse est du JSON
        header('Content-Type: application/json; charset=utf-8');
        
        // Encode les données en JSON et les affiche
        echo json_encode($users, JSON_PRETTY_PRINT);
    }

    public function showCreateUserForm(): void
    {
        // Affiche le formulaire de création d'utilisateur
        $this->render('home/create-user', params: [
            'title' => 'Créer un utilisateur'
        ]);
    }

    public function createUser(): void
    {
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
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur lors de la création de l\'utilisateur.'], JSON_PRETTY_PRINT);
        }
    }

    public function showLoginUserform(): void{
        $this->render('home/login-user', params:[
            'title' => 'Connectez à un compte'
        ]);
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

        if (empty($input['email']) || empty($input['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Les champs "email" et "password" sont requis.'], JSON_PRETTY_PRINT);
            return;
        }

        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['error' => 'Format d\'email invalide.'], JSON_PRETTY_PRINT);
            return;
        }
    }
}