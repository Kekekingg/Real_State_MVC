<?php

namespace Controllers;

use MVC\Router;
use Model\PropertyDB;

class PageController {
    public static function index(Router $router) {

        $properties = PropertyDB::get(3);
        $login = true;

        $router->render('pages/index', [
            'properties' => $properties,
            'login' => $login
        ]);
    }

    public static function aboutUs() {
        echo "From About Us";
    }

    public static function properties() {
        echo "From Properties";
    }

    public static function property() {
        echo "From Property";
    }

    public static function blog() {
        echo "From Blog";
    }

    public static function entry() {
        echo "From Entry";
    }

    public static function contact() {
        echo "From Contact";
    }
}