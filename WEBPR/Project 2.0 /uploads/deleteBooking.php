<?php
  session_start();
  require "../php/globals.php";
  require "../php/reusables.php";
  checkSession($_SESSION["typeLogged"], "user", false, "../php/logOut.php");
  try {
    $user = $_SESSION["name"];
    $roomName = urldecode($_GET["room"]);
    $hotelName = urldecode($_GET["hotel"]);

    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $sth = $conn->prepare("DELETE FROM bookings WHERE hotelname = :hotelname AND roomname = :roomname AND bookedby = :bookedby");
    $sth->bindParam(':hotelname', $hotelName, PDO::PARAM_STR, strlen($hotelName));
    $sth->bindParam(':roomname', $roomName, PDO::PARAM_STR, strlen($roomName));
    $sth->bindParam(':bookedby', $user, PDO::PARAM_STR, strlen($user));
    if (!$sth->execute())
      throw new PDOException('An error occurred');
    echo 'succesfully deleted';

    require "uploadNotification.php";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $sth = $conn->prepare("SELECT * FROM likes WHERE likes.room = :room AND likes.hotel = :hotel AND likes.likedby != :user");
    $sth->bindParam(':room', $roomName, PDO::PARAM_STR, strlen($roomName));
    $sth->bindParam(':hotel', $hotelName, PDO::PARAM_STR, strlen($hotelName));
    $sth->bindParam(':user', $user, PDO::PARAM_STR, strlen($user));
    if (!$sth->execute())
      throw new PDOException('An error occurred');
    echo "  $roomName $hotelName  ".date('Y-m-d').date('H:i:s');
    while ($row = $sth->fetch(PDO::FETCH_NUM)) {
      uploadNotification($row[0], "The room $roomName from the hotel $hotelName that you were interested in is now available for booking", date('Y-m-d'), date('H:i:s'), $roomName, $hotelName);
    }
    echo 'added all notifications';
    header("location: ../notifications.php");

  } catch (PDOException $e) {
    print "Error! " . $e->getMessage() . "\n";
    die();
  } catch (Exception $e) {
    print "Error! " . $e->getMessage() . "\n";
    die();
  }
  
?>