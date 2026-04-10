<?php

namespace Model;

class Sellers extends ActiveRecord {
    protected static $table = 'sellers';

    protected static $columnsDB = ['id', 'name', 'last_name', 'phone'];

    public $id;
    public $name;
    public $last_name;
    public $phone;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->last_name = $args['last_name'] ?? '';
        $this->phone = $args['phone'] ?? '';
    }

        public function validate() {

        if(!$this->name) {
            self::$errors[] = 'Name must be provided';
        }

        if(!$this->last_name) {
            self::$errors[] = 'Last name must be provided';
        }

        if(!$this->phone) {
            self::$errors[] = 'Phone must be provided';
        }

        if(!preg_match('/[0-9]{10}/', $this->phone)) {
            self::$errors[] = 'Invalid format';
        }

        return self::$errors;
    }
}