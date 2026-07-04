<?php

namespace Model;

class Admin extends ActiveRecord {
    // Data Base
    protected static $table = 'users';
    protected static $columnsDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validateAuth(){
        if(!$this->email) {
            self::$errors[] = "Email is required";
        }

        if(!$this->password) {
            self::$errors[] = "Password is required";
        }

        return self::$errors;
    }

    public function userExist(){
        // Check if the user exist 
        $query = "SELECT * FROM " . self::$table . " WHERE email = '" . $this->email . "' LIMIT 1";

        $result = self::$db->query($query);

        if(!$result->num_rows) {
            self::$errors[] = 'Account not found';
            return;
        }
        return $result;
    }

    public function checkPassword($result) {
        $user = $result->fetch_object();

        $authenticated = password_verify($this->password, $user->password);

        if(!$authenticated) {
            self::$errors[] = 'Incorrect password';
        }
        return $authenticated;
    }

    public function userAuthentication() {
        session_start();

        // Fill array session
        $_SESSION['user'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }
}