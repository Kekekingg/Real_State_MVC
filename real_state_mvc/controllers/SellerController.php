<?php

namespace Controllers;

use MVC\Router;
use Model\Sellers;

class SellerController {

    public static function create(Router $router ) {

        $errors = Sellers::getErrors();

        $seller = new Sellers;

        $router->render('/sellers/create', [
            'errors' => $errors,
            'seller' => $seller
        ]);
    }

    public static function update ( ) {
        echo "Update Seller";
    }

    public static function delete ( ) {

    }
}