<?php

namespace Controllers;

use MVC\Router;
use Model\Sellers;

class SellerController {

    public static function create(Router $router ) {

        $errors = Sellers::getErrors();

        $seller = new Sellers;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Creates a new instance
            $seller =  new Sellers($_POST['seller']); // Vendedor if not work with seller

            // Validate that no fields are empty
            $errors = $seller->validate();

            // There are no errors
            if(empty($errors)) {
                $seller->save();
            }
        }

        $router->render('/sellers/create', [
            'errors' => $errors,
            'seller' => $seller
        ]);
    }

    public static function update(Router $router) {

        // Fetch seller array
        $errors = Sellers::getErrors();

        $id = checkORedirect('/admin');

        $sellers = Sellers::find($id);

        // Run code after form submission
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Assign attributes
            $args = $_POST['seller'];

            $sellers->synchronize($args);

            // Validation
            $errors = $sellers->validate();

            if(empty($errors)) {
                $sellers->save();
            }
        }

        $router->render('/sellers/update', [
            'seller' => $sellers,
            'errors' => $errors,
        ]);
    }

    public static function delete ( ) {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validate ID
            $id = $_POST['id'] ?? null;
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id) {
                $type = $_POST['tipo'];
                
                if(validateCT($type)) {
                    $seller = Sellers::find($id);
                    $seller->delete();
                }
            }
        }
    }
}