<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\HistoriqueAchat;

class HistoriqueAchatController extends Controller {

    public function showHistory(): void {
        if (empty($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] === false){
            header('Location: /users/login');
            return;
        }

        $userId = $_SESSION['user_id'];
        $historique = HistoriqueAchat::getHistoryByUserId($userId);

        $this->render('profile/historique', params: [
            'title' => 'Mon Historique d\'Achats',
            'historique' => $historique
        ]);
    }
}
