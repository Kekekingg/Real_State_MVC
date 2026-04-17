<?php

namespace Controllers;

use MVC\Router;
use Model\PropertyDB;

class PageController {
    public static function index(Router $router) {

        $listing = PropertyDB::get(3);
        $login = true;

        $router->render('pages/index', [
            'listing' => $listing,
            'login' => $login
        ]);
    }

    public static function aboutUs(Router $router) {
        
        // Since this is a static view, the array is not required
        $router->render('/pages/about-us');
    }

    public static function properties(Router $router) {

        $listing = PropertyDB::all();

        $router->render('/pages/listing', [
            'listing' => $listing
        ]);
    }

    public static function property(Router $router) {

        $id = checkORedirect('/listing');

        // Seach the property by ID
        $property = PropertyDB::find($id);

        $router->render('pages/property', [
            'property' => $property
        ]);
    }

    public static function blog(Router $router) {
        $router->render('pages/blog');
    }

    public static function entry(Router $router) {
        $router->render('pages/entry');
    }

    public static function contact(Router $router) {

        if($_SERVER['REQUEST_METHOD'] === 'POST' ) {
            debugging($_POST);
        }
        $router->render('pages/contact', [

        ]);
    }
}