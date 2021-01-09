<?php
  session_start();
  require "../php/globals.php";
  require "../php/reusables.php";
  checkSession($_SESSION["typeLogged"], "enterprise", false, "../php/logOut.php");

  try {
    //ESTABLISHING CONNECTION
    echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    
    //GETTING PARAMETERS
    echo "<p>succesfully connected</p>";
    $hotelName = $_POST["hotelName"];
    $roomName = $_POST["roomName"];
    $description = $_POST["roomDescription"];
    $cost = $_POST["cost"];
    $startdate = $_POST["startdate"];
    $enddate = $_POST["enddate"];
    $max = $_POST["timeslotmax"];
    $long = $_POST["long"];
    $lat = $_POST["lat"];
    
    echo "$long, $lat";

    //CHECKING PARAMETERS
    echo "<p>checking parameters</p>";
    if (strlen($roomName) > 30 || strlen($description) > 200 || !isset($hotelName)) 
      throw new Exception('parameters entered are incorrect');
    if ($cost < 0)
      throw new Exception('cost entered falsely');
    if (!isset($long) || !isset($lat)) 
      throw new Exception('You need to give a location to your room');
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
    if (isset($max) && $max < 0) 
      throw new Exception('your timeslot must not be below 0');

    //INSERTING INTO rooms
    echo "<p>parameters correct</p><p>adding room to database</p>";
    $sql = "INSERT INTO rooms
    (belongstohotel, name, description, cost, startdate, enddate, timeslotmax, long, lat)
    VALUES
    (:belongstohotel, :name, :description, :cost, :startdate, :enddate, NULLIF(:timeslotmax::integer,'0'), :long, :lat);";
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
    echo "<p>added room to database</p>";

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
    print "Error! " . $e->getMessage() . "\n";
    die();
  } catch (Exception $e) {
    print "Error! " . $e->getMessage() . "\n";
    die();
  }
  
?>