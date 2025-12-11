<?php

declare(stict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Minj\Models\Product;

final class ComputerProduct extends Controller {

    public function listComputerProducts(): void {
        $computerproducts = Product::getAll();

        $this->render('product/list-computerproducts', params: [
            'title' => 'Liste des Ordinateurs disponibles',
            'computerproducts' => $computerproducts
        ]);
    }
}