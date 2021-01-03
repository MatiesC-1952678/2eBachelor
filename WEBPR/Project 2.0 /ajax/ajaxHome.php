<?php
    require '../php/reusables.php';

    define("ERROR_DB", 0); 
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);

    if ($conn) {
        switch ($_POST["type"]) {
            case ("Room"):
              showSearch("SELECT * FROM hotels,rooms WHERE rooms.belongstohotel = hotels.name AND LOWER(rooms.name) LIKE :search;", $_POST["search"]);
              break;
            case ("Hotel"):
              showSearch("SELECT * FROM hotels WHERE LOWER(hotels.name) LIKE :search;", $_POST["search"], false);
              break;
            case ("User"):
              showUsers("SELECT * FROM users WHERE LOWER(users.username) LIKE :search;", $_POST["search"], "Room", "Room-Title");
              break;
            case ("Enterprise"):
              showUsers("SELECT * FROM enterprises WHERE LOWER(enterprises.name) LIKE :search;", $_POST["search"], "Room", "Room-Title", false);
              break;
            case (""):
            default:
              break;
        }
    } else
        echo ERROR_DB;
    
    $conn = null;
?>