<?php
    session_start();
    require '../php/globals.php';
    require '../php/reusables.php';
    require 'uploadNotification.php';
    checkSession($_SESSION["typeLogged"], "", true, "../php/logOut.php");

    function delete($sql, $key1, $key2) {
        try {
            $conn = new PDO("pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare($sql);
            $sth->bindParam( ':key1', $key1, PDO::PARAM_STR, strlen($key1));
            $sth->bindParam( ':key2', $key2, PDO::PARAM_STR, strlen($key2));
            $sth->execute();
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die(); 
        }
    }

    $type = $_GET["type"];
    $key1 = $_GET["key1"];
    $key2 = $_GET["key2"];
    $key3 = $_GET["key3"];

    $user = $_SESSION["name"];
    $admin = $_SESSION["admin"];
    //USE IN OTHER PLACES!
    if ($user != $key1) {
        if ($admin != true) {
            echo '<p> not your account </p>';
            die();
        }
    }
    $url = "";
    echo "$key2 $key3";
    switch ($type) {
        case "room":
            notifyBookings("SELECT * FROM bookings WHERE roomname = :key2 AND hotelname = :key1", $key2, $key3, "the room ".$key3." from the hotel ".$key2." you had booked is no longer available.");
            delete("DELETE FROM rooms WHERE rooms.belongstohotel = :key1 AND rooms.name = :key2", $key2, $key3);
            echo "<p> succesfully deleted room</p>";
            $url = "../management.php";
            break;
        case "hotel";
            notifyBookings("SELECT * FROM bookings,rooms WHERE bookings.roomname = rooms.name AND bookings.hotelname = rooms.belongstohotel AND bookings.hotelname = :key1", $key2, "", "all the rooms from $key2 are deleted because this hotel is no longer available.");
            delete("DELETE FROM hotels WHERE hotels.name = :key1", $key2, "");
            echo "<p> succesfully deleted hotel</p>";
            $url = "../management.php";
            break;
        case "user";
            notifyBookings("SELECT likedby,room,hotel FROM likes,bookings WHERE likes.room = bookings.roomname AND likes.hotel = bookings.hotelname AND bookings.bookedby = :key1", $key1, "", "all the rooms, user $key1 had booked are now available because this user no longer exists.");
            delete("DELETE FROM users WHERE users.username = :key1", $key1, "");
            $url = "../php/logOut.php";
            break;
        case "enterprise";
            notifyBookings("SELECT bookedby,roomname,hotelname FROM bookings,hotels,rooms WHERE hotels.belongstoenterprise = :key1 AND hotels.name = rooms.belongstohotel AND bookings.roomname = rooms.name AND bookings.hotelname = hotels.name", $key1, "", "everything the hotel $key1 owned is no longer available because this enterprise no longer exists.");
            delete("DELETE FROM enterprises WHERE enterprises.name = :key1", $key1, "");
            $url = "../php/logOut.php";
            break;
        default;
            break;
    }
    if ($admin == true) 
        $url = "../admin.php";
    header("location: $url");
?>