<?php 

namespace Controllers;
use MVC\Router;
use Model\PropertyDB;
use Model\Sellers;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

class PropController {
    public static function index(Router $router) {
        
        $properties = PropertyDB::all();

        $sellers = Sellers::all();

        // Display conditional message
        $result = $_GET['result'] ?? $_GET['resultado'] ?? null;

        $router->render('properties/admin' , [
            // Key name is the same as values name for facility
            'properties' => $properties,
            'result' => $result,
            'sellers' => $sellers

        ]);
    }

    public static function create(Router $router) {

        $property = new PropertyDB;
        $sellers = Sellers::all();

        // Array of error messages
        $errors = PropertyDB::getErrors();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $property = new PropertyDB($_POST['property']);

            //Generate a uniq name
            $imageName = md5( uniqid(rand(), true) ) . ".jpg";

            //Manager configuration
            if(!empty($_FILES['property']['tmp_name']['image'])) {
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['property']['tmp_name']['image'])->cover(800,600);
                $property->setImage($imageName);
            }

            $errors = $property->validate();

            //Check if the error array is empty
            if(empty($errors)) {

                /** Uploading Files **/
                if(!is_dir(IMAGE_DIRECTORY)) {
                    mkdir(IMAGE_DIRECTORY);
                }

                // Store the uploaded image in the database
                $image->save(IMAGE_DIRECTORY . $imageName);

                //Save in the DB
                $property->save();
            }
        }

        $router->render('properties/create', [
            'property' => $property,
            'sellers' => $sellers,
            'errors'=> $errors
        ]);

    }
    public static function update(Router $router) {
        $id = checkORedirect('/admin');

        $property = PropertyDB::find($id);

        $sellers = Sellers::all();

        $errors = PropertyDB::getErrors();

        // Method POST for update
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Assign attributes
            $args = $_POST['property'];

            $property->synchronize($args);

            // Validation
            $errors = $property->validate();

            // File upload
            // Generate unique filename
            $imageName = md5( uniqid(rand(), true) ) . ".jpg";

            if($_FILES['property']['tmp_name']['image']) {
                $manager = new Image(Driver::class);
                $image = $manager->read($_FILES['property']['tmp_name']['image'])->cover(800,600);
                $property->setImage($imageName);
            }

            if(empty($errors)) {
                if($_FILES['property']['tmp_name']['image']) {
                    // Store the image
                    $image->save(IMAGE_DIRECTORY . $imageName);
                }

                $property->save();
            }
    }

        $router->render('/properties/update', [
            'property' => $property,
            'sellers' => $sellers,
            'errors' => $errors
        ]);
    }

    public static function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validate ID
            $id = $_POST['id'] ?? null;
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if($id) {
                $type = $_POST['tipo'];

                if(validateCT($type)) {
                    $property = PropertyDB::find($id);
                    $property->delete();
                }
            }
        }
    }
}