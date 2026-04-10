<?php

namespace MVC;

class Router {
    public $routeGET =[];
    public $routePOST =[];

    // All URLs obtained through get
    public function get($url, $fn) {
        $this->routeGET[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->routePOST[$url] = $fn;
    }

    public function checkRoute() {
        $currentURL = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if($method === 'GET') {
            // Detect the associated functions
            $fn = $this->routeGET[$currentURL] ?? null;
        } else {
            $fn = $this->routePOST[$currentURL] ?? null;
        }

        if($fn) {
            // The URL exists and has an associated function
            call_user_func($fn, $this);
        } else {
            echo "Page not found...";
        }
    }

    // Render the layout
    public function render($view, $data = []) {

        foreach($data as $key => $value) {
            $$key = $value; // Create dynamic variables from array keys (e.g. $username, $email) and assign their values
        }

        ob_start();//Starts output buffering
        include __DIR__ . "/views/$view.php";

        $content = ob_get_clean();// Get and clean the output buffer

        include __DIR__ . '/views/layout.php';
    }
}