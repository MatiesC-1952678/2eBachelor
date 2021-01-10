<?php
  session_start();
  require "../php/globals.php";
  require "../php/reusables.php";
  require "../php/inputChecks.php";
  require 'uploadNotification.php';
  checkSession($_SESSION["typeLogged"], "enterprise", false, "../error.php");
  
  try {
    //echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    
    //echo "<p>succesfully connected</p>";
    $originalHotel = $_POST["hotel"];
    $originalRoom = $_POST["original"];
    $hotelName = $_POST["hotelName"];
    $roomName = $_POST["roomName"];
    $description = $_POST["roomDescription"];
    $cost = $_POST["cost"];
    $long = $_POST["long"];
    $lat = $_POST["lat"];

    //echo "<p> $originalHotel _ $originalRoom _ $hotelName _ $roomName _ $description _ $cost </p>";
    $sth = $conn->prepare("SELECT * FROM hotels,rooms WHERE rooms.belongstohotel = :originalhotel AND rooms.name = :originalroom");
    $sth->bindParam(':originalhotel', $originalHotel, PDO::PARAM_STR, strlen($originalHotel));
    $sth->bindParam(':originalroom', $originalRoom, PDO::PARAM_STR, strlen($originalRoom));
    if (!$sth->execute())
      throw new PDOException('An error occurred');
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    if (empty($hotelName))
        $hotelName = $row["belongstohotel"];
    if (empty($roomName))
        $roomName = $row["name"];
    if (empty($description))
        $description = $row["description"];
    if (empty($cost))
        $cost = $row["cost"];
    if (empty($long))
        $long = $row["long"];
    if (empty($lat))
        $long = $row["lat"];

    //echo "<p> $originalHotel _ $originalRoom _ $hotelName _ $roomName _ $description _ $cost </p>";
    notifyBookings("SELECT * FROM bookings WHERE roomname = :key2 AND hotelname = :key1", $originalHotel, $originalRoom, "the room ".$originalRoom." from the hotel ".$originalHotel." you has undergone some changes. Look it up to make sure you aren't missing anything.");

    //echo "<p>checking parameters</p>";
    checkMinMax(strlen($roomName), 5, 30, "The Name is not between 5 and 30 characters. Go back and retry.");
    checkMinMax(strlen($description), 0, 200, "Description is longer than 200 characters. Go back and retry.");
    issetCorrect($hotelName, "You did not select a hotel from the options given. Go back and retry.");
    checkMinMax($cost, 0, 9999999999, "Your cost must be 0 or higher. Go back and retry");
    issetCorrect($long, "You need to give a location to your room. Go back and retry");
    issetCorrect($lat, "You need to give a location to your room. Go back and retry");
    
    //echo "<p>parameters correct</p><p>adding room to database</p>";
    $sql = "UPDATE rooms SET
    belongstohotel = :belongstohotel, name = :name, description = :description, cost = :cost, long = :long, lat = :lat
    WHERE
    belongstohotel = :originalhotel AND name = :originalroom";
    $sth = $conn->prepare($sql);
    $sth->bindParam( ':originalhotel', $originalHotel, PDO::PARAM_STR, strlen($originalHotel));
    $sth->bindParam( ':originalroom', $originalRoom, PDO::PARAM_STR, strlen($originalRoom));
    $sth->bindParam( ':belongstohotel', $hotelName, PDO::PARAM_STR, strlen($hotelName));
    $sth->bindParam( ':name', $roomName, PDO::PARAM_STR, strlen($roomName));
    $sth->bindParam( ':description', $description, PDO::PARAM_STR, strlen($description));
    $sth->bindParam( ':cost', $cost, PDO::PARAM_INT);
    $sth->bindParam( ':long', $long, PDO::PARAM_INT);
    $sth->bindParam( ':lat', $lat, PDO::PARAM_INT);
    if (!$sth->execute())
      throw new PDOException('An error occurred');
    //echo "<p>added room to database</p>";
    if ($_SESSION["admin"] == true) 
        $url = "../admin.php";
    else
        $url = "../management.php";
    header("location: $url ");

  } catch (PDOException $e) {
    header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
    die();
  } catch (Exception $e) {
    header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
    die();
  }
  
?>