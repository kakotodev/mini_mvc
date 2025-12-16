<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\User;

final class UserProfilController extends Controller {

    public function showProfileUserForm(): void{
        $this->render('profile/user-profile', params:[
            'title'=> 'Informations de vos profils'
        ]);
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