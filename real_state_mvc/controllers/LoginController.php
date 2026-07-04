<?php

namespace Controllers;
use MVC\Router;
use Model\Admin;

class LoginController {
    public static function login(Router $router) {
        
        $errors = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST);
            $errors = $auth->validateAuth();

            if(empty($errors)) {
                // Check if the user exist
                $result = $auth->userExist();

                if(!$result) {
                    // Check if users exist (error message)
                    $errors = Admin::getErrors();
                } else {
                    // Check password
                    $authenticated = $auth->checkPassword($result);

                    if($authenticated) {
                        // Authenticate users
                        $auth->userAuthentication();

                    } else {
                        //Incorrect password (error message)
                        $errors = Admin::getErrors();
                    }
                }
            }
        }


        $router->render('auth/login', [
            'errors' => $errors
        ]);
    }
    public static function logout() {
        session_start();

        $_SESSION = [];
        header('Location: /');
    }
}