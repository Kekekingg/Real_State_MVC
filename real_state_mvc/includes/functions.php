<?php 

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCTIONS_URL', __DIR__ . '/functions.php');
define('IMAGE_DIRECTORY', $_SERVER['DOCUMENT_ROOT'] . '/images/');

function includeTemplate (string $name, bool $isStart = false) {    
    include TEMPLATES_URL . "/$name.php";
}

function isAuth() {
    session_start();

    if(!$_SESSION['login']) {
        header('Location: /');
    } 
 }
 
function debugging($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";

    exit;
}

// Escape / Sanitize the HTML
function sanitize($html): string {
    $s = htmlspecialchars($html);
    return $s;
}

// Validate the content type
function validateCT($type) {
    $types = ['seller', 'property'];

    return in_array($type, $types);
}

//show the messages
function showNoti($code) {
    $message = '';

    switch($code) {
        case 1: 
            $message = 'Created successfully';
            break;
        case 2: 
            $message = 'Updated successfully';
            break;
        case 3: 
            $message = 'Deleted successfully';
            break;
        default:
            $message = false;
            break;
    } 
    return $message;
}

function checkORedirect(string $url) {
    // Validate URL using valid ID
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header("Location: $url");
    }

    return $id;
}