<?php

namespace Model;

class PropertyDB extends ActiveRecord {
    protected static $table = 'properties';
    protected static $columnsDB = ['id', 'title', 'price', 'image', 'description', 'bedrooms', 'wc', 'parking_space', 'created', 'sellers_id'];

    public $id;
    public $title;
    public $price;
    public $image;
    public $description;
    public $bedrooms;
    public $wc;
    public $parking_space;
    public $created;
    public $sellers_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->title = $args['title'] ?? '';
        $this->price = $args['price'] ?? '';
        $this->image = $args['image'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->bedrooms = $args['bedrooms'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->parking_space = $args['parking_space'] ?? '';
        $this->created = date('Y/m/d');
        $this->sellers_id = $args['sellers_id'] ?? '';
    }

    public function validate() {

        if(!$this->title) {
            self::$errors[] = 'You must add a title';
        }

        if(!$this->price) {
            self::$errors[] = "Price is required";
        }

         if( strlen($this->description) < 50 ) {
            self::$errors[] = "Description is required and must have al least 50 characters";
        }

         if(!$this->bedrooms) {
            self::$errors[] = "Number of rooms is required";
        }

         if(!$this->wc) {
            self::$errors[] = "Number of bathrooms is required";
        }

        if(!$this->parking_space) {
            self::$errors[] = "Number of parking spaces is required";
        }

        if(!$this->sellers_id) {
            self::$errors[] = "Select a seller";
        }

        if(!$this->image) {
            self::$errors[] = "Image is required";
        }

        return self::$errors;
    }
}