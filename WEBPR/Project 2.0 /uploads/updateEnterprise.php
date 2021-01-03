<?php
  session_start();
  require '../php/globals.php';
  require '../php/reusables.php';
  require 'uploadNotification.php';
  checkSession($_SESSION["typeLogged"], "enterprise", false, "../php/logOut.php");

  try {
    echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $original = $_GET["original"];
    $name = $_POST["enterpriseName"];
    $description = $_POST["enterpriseDescription"];
    $email = $_POST["enterpriseEmail"];
    $phone = $_POST["enterprisePhone"];
    $password = $_POST["enterprisePassword"];

    echo "<p> $original _ $name _ $description _ $email _ $phone _ $password </p>";

    $sth = $conn->prepare("SELECT * FROM enterprises WHERE enterprises.name = :original");
    $sth->bindParam( ':original', $original, PDO::PARAM_STR, strlen($original) );
    $sth->execute();
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    if (empty($name))
        $name = $row["name"];
    if (empty($description))
        $description = $row["description"];
    if (empty($email))
        $email = $row["email"];
    if (empty($phone))
        $phone = $row["phone"];
    if (empty($password))
        $password = $row["password"];

    echo "<p> $original _ $name _ $description _ $email _ $phone _ $password </p>";

    notifyBookings("SELECT bookedby,roomname,hotelname FROM bookings,hotels,rooms WHERE hotels.belongstoenterprise = :key1 AND hotels.name = rooms.belongstohotel AND bookings.roomname = rooms.name AND bookings.hotelname = hotels.name", $original, "", "the enterprise $original has undergone some changes. Look it up to make sure you aren't missing anything.");

    echo '<p> checking parameters </p>';
    if (strlen($name) < 5 || strlen($name) > 30) {
        throw new Exception('name is not between 5 and 30 char', 1);
    }
    if (strlen($description) > 200) {
        throw new Exception('description is 200', 1);
    }
    if (strlen($email) > 50) {
        throw new Exception('email is too long');
    }
    if (strlen($password) < 5 || strlen($password) > 30) {
        throw new Exception("password is not correct", 1);
    }

    $sql =  "UPDATE enterprises SET 
    name = :name, description = :description, email = :email, phone = :phone, password = :password
    WHERE name = :original";
    $sth = $conn->prepare($sql);
    $sth->bindParam( ':name', $name, PDO::PARAM_STR, strlen($name) );
    $sth->bindParam( ':description', $description, PDO::PARAM_STR, strlen($description) );
    $sth->bindParam( ':email', $email, PDO::PARAM_STR, strlen($email) );
    $sth->bindParam( ':phone', $phone, PDO::PARAM_STR, strlen($phone) );
    $sth->bindParam( ':password', $password, PDO::PARAM_STR, strlen($password) );
    $sth->bindParam( ':original', $original, PDO::PARAM_STR, strlen($original) );
    $sth->execute();

    if ($_SESSION["admin"] == true)
      $url = "../admin.php";
    else  {
      $_SESSION["name"] = $name;
      $url = "../management.php";
    }
    header("location: $url ");

  } catch (PDOException $e) {
    print "Error! " . $e->getMessage() . "\n";
    echo '<p><a href="../login.php"> go back </a></p>';
    die();
  } catch (Exception $e) {
    print "Error! " . $e->getMessage() . "\n";
    echo '<p><a href="../login.php"> go back </a></p>';
    die();
  }
?>