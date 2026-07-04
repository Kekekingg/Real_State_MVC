<?php 

use Dotenv\Dotenv;
use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeload();

require __DIR__ . '/functions.php';
$db = require __DIR__ . '/config/database.php';

// Connecting to DB
ActiveRecord::setDB($db);

