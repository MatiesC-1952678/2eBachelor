<?php
  session_start();
  require "../php/globals.php";
  require "../php/reusables.php";
  checkSession($_SESSION["typeLogged"], "enterprise", false, "../php/logOut.php");

  try {
    echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    
    echo "<p>succesfully connected</p>";
    $enterpriseName = $_SESSION["name"];
    $hotelName = $_POST["hotelName"];
    $description = $_POST["hotelDescription"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $country = $_POST["hotelCountry"];
    echo "<p>$startTime & $endTime</p>";
    
    echo "<p>checking parameters</p>";
    if(strtotime($startDate) > strtotime($endDate)){
        throw new Exception("starting date is behind ending date");
    }
    if(strtotime($startTime) > strtotime($endTime)) {
        throw new Exception("starting time is behind ending time");
    }
    if (strlen($hotelName) > 30 || strlen($description) > 200 || !isset($country)) {
        throw new Exception('parameters entered are incorrect');
    }

    echo "<p>parameters correct</p><p>adding hotel to database</p>";
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
    echo "<p>added hotel to database</p>";
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