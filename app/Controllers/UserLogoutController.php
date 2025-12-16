<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;


final class UserLogoutController extends Controller{

    public function showLogoutUserForm(): void{
        $this->render('home/logout-user', parmams:[
            'title' => 'Se deconnecter à un compte'
        ]);
    }

    public function LogoutUser(): void{

        header('Content-Type: application/json; charset=utf-8');

        session_unset();
        session_destroy();
        header('Location: /');

    }

}

?>