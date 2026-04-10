<?php

namespace Model;

class ActiveRecord {
    // Protected database (never overwritten)
    protected static $db;
    protected static $columnsDB = [];
    protected static $table = '';

    // Instance properties
    public $id;
    public $image;

    // Errors/Validation
    protected static $errors = [];

    // Define the database connection
    public static function setDB($database) {
        self::$db = $database;
    }


    public function save() {
        if (!is_null($this->id)) {
            //Update
            $this->update();
        } else {
            //Create a new record
            $this->create();
        }
    }

    public function create() {
        //Assign the next available ID
        $this->id = self::getNextId();

        // Sanitize the data
        $attributes = $this->sanitizeData();

        // Insert Into the DB
        $query = "INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= ") VALUES ('";
        $query .=  join("', '", array_values($attributes));
        $query .= "')";

        $result = self::$db->query($query);

        if($result) {
            //Redireccionar al usuario
            header('Location: /admin?result=1');
            exit;
        }
    }

    public function update() {
        // Sanitizar los datos
        $attributes = $this->sanitizeData();

        $valores = []; //Goes to the object in memory and binds attributes with values
        foreach($attributes  as $key => $values) {
            $values[] = "{$key}='{$values}'";
        }

        $query = " UPDATE " . static::$table . " SET ";
        $query .= join(',',$valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $result = self::$db->query($query);

        if($result) {
            //Redirect the user
            header('Location: /admin?result=2');
            exit;
        }
    }


    //Delete a record
    public function delete() {

        $query = "DELETE FROM " . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

        $result = self::$db->query($query);

        if($result) {
            $this->deleteImage();
            header('Location: /admin?result=3');
            exit;
        } 
    }

    //Identify and map database attributes
    public function attributes() {
        $attributes = [];

        foreach(static::$columnsDB as $column) {
            //Include the ID only if it is already assigned (for creation with a specific ID)
            if($column === 'id' && !isset($this->id)) continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    public function sanitizeData() {
        $attributes = $this->attributes();
        $sanitizing = [];

        foreach($attributes as $key => $value) {
            //Only sanitize the values
            $sanitizing[$key] = self::$db->escape_string($value);
        }
        return $sanitizing;
    }

    // Delete the file
    public function deleteImage() {
        //Verify if the file exist
        $exist = file_exists(IMAGE_DIRECTORY . $this->image);
        if($exist) {
            unlink(IMAGE_DIRECTORY . $this->image);
        }
    }

    // Validation
    public static function getErrors() {
        return static::$errors;
    }

    public function validate() {
        static::$errors = [];
        return static::$errors;
    }

    public function setImage($image) {
        //Delete the previous image

        if(!is_null($this->id)) {
            $this->deleteImage();
        }

        //Assign the image attribute the name of the image
        if($image) {
            $this->image = $image;
        }
    }

    //List all records
    public static function all() {
        $query = "SELECT * FROM " . static::$table;//Return an array

        $result = self::querySQL($query);

        return $result;
    }

    // Get a certain number of records
    public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$table . " LIMIT " . $cantidad;//Return an array

        $result = self::querySQL($query);

        return $result;
    }

    // Find a record by its ID
    public static function find($id) {
        $query = "SELECT * FROM " . static::$table . " WHERE id = $id";

        $result = self::querySQL($query);
        return array_shift($result);//Returns the first element of an array
    }

    public static function querySQL($query){

        //1. Consult the Data Base
            $result = self::$db->query($query);

        //2. //Iterate over the results
            $array = [];
            while($record = $result->fetch_assoc()) {
                $array[] = static::createObj($record);
            }

        //3. Release memory
            $result->free();

        //4. Return the results
            return $array;
    }

    //Function: converts an array to an object
    protected static function createObj($record) {
        $object = new static;

        //Create an objent in memory with the arrays
        foreach($record as $key => $value) {
            if(property_exists($object, $key)) {
                $object->$key = $value;
            }
        }

        return $object;
    }
    /* END OF PROPERTY LIST */

    //Synchronize the object in memory with the changes made by the user
    public function synchronize($args = []) {
        //Rewrite each attribute of the object in memory
        foreach($args as $key => $value) { //Key/value because is an associative array
            if(property_exists($this, $key ) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    //Get the next available ID (reuse gaps and restart when is empty)
    public static function getNextId() {
        // Obtener todos los IDs existentes ordenados
        $query = "SELECT id FROM " . static::$table . " ORDER BY id ASC";
        $result = self::$db->query($query);

        $ids = [];
        while($row = $result->fetch_assoc()) {
            $ids[] = $row['id'];
        }

        //If there is no ID's, start from 1
        if(empty($ids)) {
            return 1;
        }

        //Find the first gaps in the sequens
        for($i = 1; ; $i++) {
            if(!in_array($i, $ids)) {
                return $i;
            }
        }
    }
}