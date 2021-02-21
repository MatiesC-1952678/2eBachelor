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
    $enterpriseName = $_SESSION["name"];
    $hotelName = $_POST["hotelName"];
    $description = $_POST["hotelDescription"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $country = $_POST["hotelCountry"];
    //echo "<p>$startTime & $endTime</p>";
    
    //CHECKING PARAMETERS
    //echo "<p>checking parameters</p>";
    dateFormatted($startDate, "Your start date is not formatted correctly. Go back and retry.");
    dateFormatted($endDate, "Your end date is not formatted correctly. Go back retry.");
    timeFormatted($startTime, "Your start time is not formatted correctly. Go back and retry.");
    timeFormatted($endTime, "Your end time is not formatted correctly. Go back and retry.");
    biggerThenTimeDate($startDate, $endDate, "The starting date that you have entered is currenlty after the ending date. Go back and retry.");
    biggerThenTimeDate($startTime, $endTime, "The starting time that you have entered is currenlty after the ending date. Go back and retry.");
    checkMinMax(strlen($hotelName), 5, 30, "The Name is not between 5 and 30 characters. Go back and retry.");
    checkMinMax(strlen($description), 0, 200, "Description is longer than 200 characters. Go back and retry.");
    issetCorrect($country, "You did not select a country from the options given. Go back and retry.");

    //ADDING HOTEL TO DATABASE
    //echo "<p>parameters correct</p><p>adding hotel to database</p>";
    $sql = "INSERT INTO hotels
    (belongstoenterprise, name, description, startdate, enddate, starttime, endtime, country)
    VALUES
    (:belongstoenterprise, :name, :description, :startdate, :enddate, :starttime, :endtime, :country);";
    $sth = $conn->prepare($sql);
    $sth->bindParam( ':belongstoenterprise', $enterpriseName, PDO::PARAM_STR, strlen($username));
    $sth->bindParam( ':name', $hotelName, PDO::PARAM_STR, strlen($hotelName));
    $sth->bindParam( ':description', $description, PDO::PARAM_STR, strlen($description));
    $sth->bindParam( ':startdate', $startDate, PDO::PARAM_STR, strlen($startDate));
    $sth->bindParam( ':enddate', $endDate, PDO::PARAM_STR, strlen($endDate));
    $sth->bindParam( ':starttime', $startTime, PDO::PARAM_STR, strlen($startTime));
    $sth->bindParam( ':endtime', $endTime, PDO::PARAM_STR, strlen($endTime));
    $sth->bindParam( ':country', $country, PDO::PARAM_STR, strlen($country));
    if (!$sth->execute())
      throw new PDOException('An error occurred');
    //echo "<p>added hotel to database</p>";

    //UPLOADING IMAGES
    for ($i = 0; $i < count($_FILES["imagesToUpload"]["name"]); $i++) {
      uploadOneImage($_FILES["imagesToUpload"]["tmp_name"][$i], $_FILES["imagesToUpload"]["name"][$i], $_FILES["imagesToUpload"]["size"][$i], $hotelName, "hotel");
    }

    //UPLOADING VIDEOS
    for ($i = 0; $i < count($_FILES["videosToUpload"]["name"]); $i++) {
      uploadOneVideo($_FILES["videosToUpload"]["tmp_name"][$i], $_FILES["videosToUpload"]["name"][$i], $_FILES["videosToUpload"]["size"][$i], $hotelName, "hotel");
    }


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