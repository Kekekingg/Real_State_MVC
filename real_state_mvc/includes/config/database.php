<?php

function connectDB() : mysqli {
    $db = mysqli_connect('localhost', 'root','root69', 'bienesraices_crud');

    if(!$db) {
        echo "Error: unable to connect";
        exit;
    }

    //Return the connection instance
    return $db;
}