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
    $hotelName = $_POST["hotelName"];
    $roomName = $_POST["roomName"];
    $description = $_POST["roomDescription"];
    $cost = $_POST["cost"];
    $startdate = $_POST["startdate"];
    $enddate = $_POST["enddate"];
    $max = $_POST["timeslotmax"];
    
    echo "<p>checking parameters</p>";
    if (strlen($roomName) > 30 || strlen($description) > 200 || $hotelName == "") 
      throw new Exception('parameters entered are incorrect');
    if ($cost < 0)
      throw new Exception('cost entered falsely');

    if (isset($startdate) && isset($enddate)) {
      if (strtotime($startdate) > strtotime($enddate))
        throw new Exception('startdate before enddate');

      $sth = $conn->prepare("SELECT * FROM hotels WHERE hotels.name = :name");
      $sth->bindParam(':name', $hotelName, PDO::PARAM_STR, strlen($hotelName));
      if (!$sth->execute())
        echo 'unsuccesfully queried';
      $row = $sth->fetch(PDO::FETCH_ASSOC);
      
      if (strtotime($row["startdate"]) > strtotime($startdate) || strtotime($row["enddate"]) < strtotime($enddate))
        throw new Exception('these dates are not in the range of the hotels opening');
    } else if ((isset($startdate) && !isset($enddate)) || (!isset($startdate) && isset($enddate)))
      throw new Exception('both dates have to be either set or not set, not one or the other');

    echo "<p>parameters correct</p><p>adding room to database</p>";
    $sql = "INSERT INTO rooms
    (belongstohotel, name, description, cost, startdate, enddate, timeslotmax)
    VALUES
    (:belongstohotel, :name, :description, :cost, :startdate, :enddate, :timeslotmax);";
    $sth = $conn->prepare($sql);
    $sth->bindParam( ':belongstohotel', $hotelName, PDO::PARAM_STR, strlen($hotelName));
    $sth->bindParam( ':name', $roomName, PDO::PARAM_STR, strlen($roomName));
    $sth->bindParam( ':description', $description, PDO::PARAM_STR, strlen($description));
    $sth->bindParam( ':cost', $cost, PDO::PARAM_INT);
    $sth->bindParam( ':startdate', $startdate, PDO::PARAM_STR, strlen($startdate));
    $sth->bindParam( ':enddate', $enddate, PDO::PARAM_STR, strlen($enddate));
    $sth->bindParam( ':timeslotmax', $max, PDO::PARAM_INT);
    $sth->execute();
    echo "<p>added room to database</p>";
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