<?php
    require '../php/globals.php';
    require '../php/reusables.php';
    define("ERROR_DB", 0); 
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);

    if ($conn) {
        showUsers("SELECT * FROM users WHERE LOWER(users.username) LIKE :search;", $_POST["search"], "Room", "Room-Title");
    } else 
        echo ERROR_DB;
    
    $conn = null;
?>