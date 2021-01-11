<?php
  session_start();
  require "../php/globals.php";
  require "../php/reusables.php";
  require "../php/inputChecks.php";
  checkSession($_SESSION["typeLogged"], "enterprise", false, "../error.php");

  try {
    //ESTABLISHING CONNECTION
    //echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    
    //GETTING PARAMETERS
    //echo "<p>succesfully connected</p>";
    $hotelName = $_POST["hotelName"];
    $roomName = $_POST["roomName"];
    $description = $_POST["roomDescription"];
    $cost = $_POST["cost"];
    $startdate = $_POST["startdate"];
    $enddate = $_POST["enddate"];
    $max = $_POST["timeslotmax"];
    $long = $_POST["long"];
    $lat = $_POST["lat"];
    
    //echo "$long, $lat";

    //CHECKING PARAMETERS
    //echo "<p>checking parameters</p>";
    checkMinMax(strlen($roomName), 5, 30, "The Name is not between 5 and 30 characters. Go back and retry.");
    checkMinMax(strlen($description), 0, 200, "Description is longer than 200 characters. Go back and retry.");
    issetCorrect($hotelName, "You did not select a hotel from the options given. Go back and retry.");
    checkMinMax($cost, 0, 9999999999, "Your cost must be 0 or higher. Go back and retry.");
    issetCorrect($long, "You need to give a location to your room. Go back and retry.");
    issetCorrect($lat, "You need to give a location to your room. Go back and retry.");

    if (!empty($startdate) && !empty($enddate)) {
      biggerThenTimeDate($startdate, $enddate, "The starting date that you have entered is currenlty after the ending date. Go back and retry.");
      
      $sth = $conn->prepare("SELECT * FROM hotels WHERE hotels.name = :name");
      $sth->bindParam(':name', $hotelName, PDO::PARAM_STR, strlen($hotelName));
      if (!$sth->execute())
        throw new Exception('Test');
      $row = $sth->fetch(PDO::FETCH_ASSOC);
      
      biggerThenTimeDate($row["startdate"], $startdate, "The starting date that you have entered is currenlty after the ending date. Go back and retry.");
      biggerThenTimeDate($enddate, $row["enddate"], "The starting date that you have entered is currenlty after the ending date. Go back and retry.");
      
    } else if ((empty($startdate) && !empty($enddate)) || (!empty($startdate) && empty($enddate))) {
      header("location: ../error.php?error=".urlencode('<p>You need to have both dates specified not just one. Go back and retry.</p>'));
      die();
    }
    if (isset($max) && $max < 0) {
      header("location: ../error.php?error=".urlencode('<p>Your timeslot is below zero. Go back and retry.</p>'));
      die();
    }
    
    //INSERTING INTO rooms
    //echo "<p>parameters correct</p><p>adding room to database</p>";
    $sql = "INSERT INTO rooms
    (belongstohotel, name, description, cost, startdate, enddate, timeslotmax, long, lat)
    VALUES
    (:belongstohotel, :name, :description, :cost, NULLIF(:startdate, '')::DATE, NULLIF(:enddate, '')::DATE, NULLIF(:timeslotmax::integer,'0'), :long, :lat);";
    $sth = $conn->prepare($sql);
    $sth->bindParam( ':belongstohotel', $hotelName, PDO::PARAM_STR, strlen($hotelName));
    $sth->bindParam( ':name', $roomName, PDO::PARAM_STR, strlen($roomName));
    $sth->bindParam( ':description', $description, PDO::PARAM_STR, strlen($description));
    $sth->bindParam( ':cost', $cost, PDO::PARAM_INT);
    $sth->bindParam( ':startdate', $startdate, PDO::PARAM_STR, strlen($startdate));
    $sth->bindParam( ':enddate', $enddate, PDO::PARAM_STR, strlen($enddate));
    $sth->bindParam( ':timeslotmax', $max, PDO::PARAM_INT);
    $sth->bindParam( ':long', $long, PDO::PARAM_STR, strlen($long));
    $sth->bindParam( ':lat', $lat, PDO::PARAM_STR, strlen($lat));
    if (!$sth->execute())
      throw new PDOException('An error occurred');
    //echo "<p>added room to database</p>";

    //UPLOADING IMAGES
    for ($i = 0; $i < count($_FILES["imagesToUpload"]["name"]); $i++) {
      uploadOneImage($_FILES["imagesToUpload"]["tmp_name"][$i], $_FILES["imagesToUpload"]["name"][$i], $_FILES["imagesToUpload"]["size"][$i], $roomName, "room");
    }

    //UPLOADING VIDEOS
    for ($i = 0; $i < count($_FILES["videosToUpload"]["name"]); $i++) {
      uploadOneVideo($_FILES["videosToUpload"]["tmp_name"][$i], $_FILES["videosToUpload"]["name"][$i], $_FILES["videosToUpload"]["size"][$i], $roomName, "room");
    }

    $url = "../management.php";
    header("location: $url ");

  } catch (PDOException $e) {
    header("location: ../error.php?error=".urlencode($e->getMessage().'<p>An error occurred. Go back and retry.</p>'));
    die();
  } catch (Exception $e) {
    header("location: ../error.php?error=".urlencode($e->getMessage().'<p>An error occurred. Go back and retry.</p>'));
    die();
  }
  
?>