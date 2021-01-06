<?php
  session_start();
  require "../php/globals.php";
  require "../php/reusables.php";
  require 'uploadNotification.php';
  checkSession($_SESSION["typeLogged"], "enterprise", false, "../php/logOut.php");

  try {
    echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    
    echo "<p>succesfully connected</p>";
    $enterpriseName = $_POST["enterprise"];
    $originalname = $_POST["original"];
    $newname = $_POST["hotelName"];
    $description = $_POST["hotelDescription"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $country = $_POST["hotelCountry"];

    echo "<p> $enterpriseName _ $originalname _ $newname _ $description _ $startDate _ $endDate _ $startTime _ $endTime _ $country";

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

    echo "<p> $enterpriseName _ $originalname _ $newname _ $description _ $startDate _ $endDate _ $startTime _ $endTime _ $country";

    notifyBookings("SELECT * FROM bookings,rooms WHERE bookings.roomname = rooms.name AND bookings.hotelname = rooms.belongstohotel AND bookings.hotelname = :key1", $originalname, "", "the hotel $originalname has undergone some changes. Look it up to make sure you aren't missing anything");
    
    echo "<p>checking parameters</p>";
    if(strtotime($startDate) > strtotime($endDate)){
        throw new Exception("starting date is behind ending date");
    }
    if(strtotime($startTime) > strtotime($endTime)) {
        throw new Exception("starting time is behind ending time");
    }
    if (strlen($newname) > 30 || strlen($description) > 200 || !isset($country)) {
        throw new Exception('parameters entered are incorrect');
    }

    

    echo "<p>parameters correct</p><p>updating hotel in database</p>";
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
    echo "<p>updated hotel in database + CASCADE</p>";
    if ($_SESSION["admin"] == true)
      $url = "../admin.php";
    else 
      $url = "../management.php";
    header("location: $url ");

  } catch (PDOException $e) {
    print "Error! " . $e->getMessage() . "\n";
    die();
  } catch (Exception $e) {
    print "Error! " . $e->getMessage() . "\n";
    die();
  }
  
?>