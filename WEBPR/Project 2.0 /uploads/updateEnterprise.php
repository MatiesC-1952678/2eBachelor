<?php
  session_start();
  require '../php/globals.php';
  require '../php/reusables.php';
  require '../php/inputChecks.php';
  require 'uploadNotification.php';
  checkSession($_SESSION["typeLogged"], "enterprise", false, "../error.php");
  try {
    //echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $original = $_POST["original"];
    $name = $_POST["enterpriseName"];
    $description = $_POST["enterpriseDescription"];
    $email = $_POST["enterpriseEmail"];
    $phone = $_POST["enterprisePhone"];
    $password = $_POST["enterprisePassword"];

    //echo "<p> $original _ $name _ $description _ $email _ $phone _ $password </p>";

    $sth = $conn->prepare("SELECT * FROM enterprises WHERE enterprises.name = :original");
    $sth->bindParam( ':original', $original, PDO::PARAM_STR, strlen($original) );
    if (!$sth->execute())
      throw new PDOException('An error occurred');
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

    //echo "<p> $original _ $name _ $description _ $email _ $phone _ $password </p>";

    notifyBookings("SELECT bookedby,roomname,hotelname FROM bookings,hotels,rooms WHERE hotels.belongstoenterprise = :key1 AND hotels.name = rooms.belongstohotel AND bookings.roomname = rooms.name AND bookings.hotelname = hotels.name", $original, "", "the enterprise $original has undergone some changes. Look it up to make sure you aren't missing anything.");

    checkMinMax(strlen($name), 5, 30, "Name is not between 5 and 30 characters. Go back and retry.");
    checkMinMax(strlen($email), 1, 50, "Email is over 50 characters. Go back and retry.");
    checkMinMax(strlen($description), 0, 200, "Description is longer than 200 characters. Go back and retry.");
    checkMinMax(strlen($password), 5, 50, "Password is not between 5 and 50 characters. Go back and retry.");
    checkMinMax(strlen($phone), 0, 50, "Phone number is longer than 200 characters. Go back and retry.");
    checkEmail($email);
    if (strlen($phone) > 0)
      checkPhone($phone);

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql =  "UPDATE enterprises SET 
    name = :name, description = :description, email = :email, phone = :phone, password = :password
    WHERE name = :original";
    $sth = $conn->prepare($sql);
    $sth->bindParam( ':name', $name, PDO::PARAM_STR, strlen($name) );
    $sth->bindParam( ':description', $description, PDO::PARAM_STR, strlen($description) );
    $sth->bindParam( ':email', $email, PDO::PARAM_STR, strlen($email) );
    $sth->bindParam( ':phone', $phone, PDO::PARAM_STR, strlen($phone) );
    $sth->bindParam( ':password', $hash, PDO::PARAM_STR, strlen($hash) );
    $sth->bindParam( ':original', $original, PDO::PARAM_STR, strlen($original) );
    if (!$sth->execute())
      throw new PDOException('An error occurred');

    if ($_SESSION["admin"] == true)
      $url = "../admin.php";
    else  {
      $_SESSION["name"] = $name;
      $url = "../management.php";
    }
    header("location: $url ");

  } catch (PDOException $e) {
    header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
    die();
  } catch (Exception $e) {
    header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
    die();
  }
?>