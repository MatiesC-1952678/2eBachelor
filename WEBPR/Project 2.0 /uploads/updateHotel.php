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
    $enterpriseName = $_POST["enterprise"];
    $originalname = $_POST["original"];
    $newname = $_POST["hotelName"];
    $description = $_POST["hotelDescription"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $country = $_POST["hotelCountry"];
    //echo "<p> $enterpriseName _ $originalname _ $newname _ $description _ $startDate _ $endDate _ $startTime _ $endTime _ $country";
    $sth = $conn->prepare("SELECT * FROM hotels WHERE belongstoenterprise = :enterprise AND name = :name");
    $sth->bindParam(':enterprise', $enterpriseName, PDO::PARAM_STR, strlen($enterpriseName));
    $sth->bindParam(':name', $originalname, PDO::PARAM_STR, strlen($originalname));
    if (!$sth->execute())
      throw new PDOException('An error occurred');
    $row = $sth->fetch(PDO::FETCH_ASSOC);

    if (empty($newname))
        $newname = $row["name"];
    if (empty($description))
        $description = $row["description"];
    if (empty($startDate))
        $startDate = $row["startdate"];
    if (empty($endDate))
        $endDate = $row["enddate"];
    if (empty($startTime))
        $startTime = $row["starttime"];
    if (empty($endTime))
        $endTime = $row["endtime"];
    if (empty($country))
        $country = $row["country"];
    
    //echo "<p> $enterpriseName _ $originalname _ $newname _ $description _ $startDate _ $endDate _ $startTime _ $endTime _ $country";
    notifyBookings("SELECT * FROM bookings,rooms WHERE bookings.roomname = rooms.name AND bookings.hotelname = rooms.belongstohotel AND bookings.hotelname = :key1", $originalname, "", "This hotel has undergone some changes. Look it up to make sure you aren't missing anything.");
   
    //echo "<p>checking parameters</p>";
    dateFormatted($startDate, "Your start date is not formatted correctly. Go back and retry.");
    dateFormatted($endDate, "Your end date is not formatted correctly. Go back retry.");
    timeFormatted($startTime, "Your start time is not formatted correctly. Go back and retry.");
    timeFormatted($endTime, "Your end time is not formatted correctly. Go back and retry.");
    biggerThenTimeDate($startDate, $endDate, "The starting date that you have entered is currenlty after the ending date. Go back and retry.");
    biggerThenTimeDate($startTime, $endTime, "The starting time that you have entered is currenlty after the ending date. Go back and retry.");
    checkMinMax(strlen($newname), 5, 30, "The Name is not between 5 and 30 characters. Go back and retry.");
    checkMinMax(strlen($description), 0, 200, "Description is longer than 200 characters. Go back and retry.");
    issetCorrect($country, "You did not select a country from the options given. Go back and retry.");
    
    //echo "<p>parameters correct</p><p>updating hotel in database</p>";
    $sql = "UPDATE hotels SET
    name = :newname, description = :description, startdate = :startdate, enddate = :enddate, starttime = :starttime, endtime = :endtime, country = :country
    WHERE
    belongstoenterprise = :belongstoenterprise AND name = :originalname;"; 
    $sth = $conn->prepare($sql);
    $sth->bindParam( ':belongstoenterprise', $enterpriseName, PDO::PARAM_STR, strlen($username));
    $sth->bindParam( ':originalname', $originalname, PDO::PARAM_STR, strlen($originalname));
    $sth->bindParam( ':newname', $newname, PDO::PARAM_STR, strlen($newname));
    $sth->bindParam( ':description', $description, PDO::PARAM_STR, strlen($description));
    $sth->bindParam( ':startdate', $startDate, PDO::PARAM_STR, strlen($startDate));
    $sth->bindParam( ':enddate', $endDate, PDO::PARAM_STR, strlen($endDate));
    $sth->bindParam( ':starttime', $startTime, PDO::PARAM_STR, strlen($startTime));
    $sth->bindParam( ':endtime', $endTime, PDO::PARAM_STR, strlen($endTime));
    $sth->bindParam( ':country', $country, PDO::PARAM_STR, strlen($country));
    if (!$sth->execute())
      throw new PDOException('An error occurred');
    //echo "<p>updated hotel in database + CASCADE</p>";
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