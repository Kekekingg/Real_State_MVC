<?php

namespace Controllers;

use MVC\Router;
use Model\PropertyDB;
use PHPMailer\PHPMailer\PHPMailer;

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

            $serverResponse = $_POST['contact'];

            // Create new instance of PHPMailer
            $mail = new PHPMailer();

            // Config SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '1aec537547bfb6';
            $mail->Password = '2e759e6ba294d8';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            // Configure email content
            $mail->setFrom('admin@realsstate.com'); //Send the email
            $mail->addAddress('admin@realsstate.com', 'RealState.com'); // Destination email address
            $mail->Subject = 'You have a new message';

            // Enable HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Define content
            $content = '<html>'; 
            $content .= '<p>You have a new message! </p>';
            $content .= '<p>Name: ' . $serverResponse['name'] . ' </p>';
            $content .= '<p>Email: ' . $serverResponse['email'] . ' </p>';
            $content .= '<p>Phone: ' . $serverResponse['phone'] . ' </p>';
            $content .= '<p>Message: ' . $serverResponse['message'] . ' </p>';
            $content .= '<p>Buy or Sell: ' . $serverResponse['type'] . ' </p>';
            $content .= '<p>Price or Budget: $' . $serverResponse['price'] . ' </p>';
            $content .= '<p>Preferred way to contact: ' . $serverResponse['contact'] . ' </p>';
            $content .= '<p>Contact Date: ' . $serverResponse['date'] . ' </p>';
            $content .= '<p>Time: ' . $serverResponse['time'] . ' </p>';
            $content .= '</html>';

            $mail->Body = $content;
            $mail->AltBody = "This is altern text without html";

            // Send Email
            if($mail->send()) { //Only return true or false
                echo "Message sent successfully";
            } else {
                echo "Message could not be sent";
            }; 
        }

        $router->render('pages/contact', [

        ]);
    }
}