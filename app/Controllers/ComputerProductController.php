<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\ComputerProduct;
use Mini\Models\Panier;

final class ComputerProductController extends Controller {

    public function listComputerProducts(): void {
        $sort = $_GET['sort'] ?? 'default';
        $computerproducts = ComputerProduct::getAll($sort);

        $this->render('computers/list-computerproducts', params: [
            'title' => 'Liste des Ordinateurs disponibles',
            'computerproducts' => $computerproducts
        ]);
    }

}