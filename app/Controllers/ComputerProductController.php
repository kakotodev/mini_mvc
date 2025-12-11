<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\ComputerProduct;

final class ComputerProductController extends Controller {

    public function listComputerProducts(): void {
        $computerproducts = ComputerProduct::getAll();

        $this->render('computers/list-computerproducts', params: [
            'title' => 'Liste des Ordinateurs disponibles',
            'computerproducts' => $computerproducts
        ]);
    }
}