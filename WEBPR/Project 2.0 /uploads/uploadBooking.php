<?php
  session_start();
  require "../php/globals.php";
  require "../php/reusables.php";
  require "../php/inputChecks.php";
  checkSession($_SESSION["typeLogged"], "user", false, "../error.php");
  try {
    $roomName = $_POST["roomName"];
    $hotelName = $_POST["hotelName"];
    //echo "<p>$roomName, $hotelName</p>";

    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $sth = $conn->prepare("SELECT hotels.startdate,hotels.enddate,rooms.startdate,rooms.enddate,rooms.timeslotmax FROM hotels,rooms WHERE hotels.name = :hotel AND rooms.name = :room AND rooms.belongstohotel = hotels.name");
    $sth->bindParam(':hotel', $hotelName, PDO::PARAM_STR, strlen($hotelName));
    $sth->bindParam(':room', $roomName, PDO::PARAM_STR, strlen($roomName));
    if (!$sth->execute())
      throw new Exception("An error occurred");
    $row = $sth->fetch( PDO::FETCH_NUM );
    
    $bookedBy = $_SESSION["name"];
    $startDateChosen = $_POST["startDate"];
    $endDateChosen = $_POST["endDate"];
    $startDateHotel = $row[0];
    $endDateHotel = $row[1];
    $startDateRoom = $row[2];
    $endDateRoom = $row[3];
    $max = $row[4];

    //echo "<p>$startDateHotel - $endDateHotel & $startDateRoom - $endDateRoom</p>";
    if (empty($startDateRoom)) {
      //echo "<p>room start date not given -> going to hotel date</p>";
      $startDateRoom = $startDateHotel;
    }
    if (empty($endDateRoom)) {
      //echo "<p>room end date not given -> going to hotel date</p>";
      $endDateRoom = $endDateHotel;
    }
    
    //echo "<p>checking parameters</p>";
    //echo "<p> $startDateChosen , $startDateRoom - $endDateChosen , $endDateRoom </p>";

    dateFormatted($startDateChosen, "Your start date is not formatted correctly. Go back and retry.");
    dateFormatted($endDateChosen, "Your end date is not formatted correctly. Go back retry.");
    biggerThenTimeDate($startDateRoom, $startDateChosen, "The starting date that you have entered is before your room is available. Go back and retry.");
    biggerThenTimeDate($endDateChosen, $endDateRoom, "The ending date that you have entered is after your room is available. Go back and retry.");
    biggerThenTimeDate($startDateChosen, $endDateChosen, "The starting date that you have entered is currenlty after the ending date. Go back and retry.");
    $datediff = round((strtotime($endDateChosen) - strtotime($startDateChosen)) / (60 * 60 * 24));
    //echo "<p> your days amount staying: ".$datediff.' max amount staying: '.$max;
    if(!empty($max) && $datediff > $max) {
      header("location: ../error.php?error=".urlencode("<p>Your booking is longer than the permitted highest timeslot. You want to stay $datediff days and you can only stay $max days. Go back and retry.</p>"));
      die();
    }

    //echo "<p> checking overlaps with other bookings </p>";
    $sth = $conn->prepare("SELECT * FROM bookings WHERE hotelname = :hotel AND roomname = :room AND (bookings.startd, bookings.endd + INTERVAL '1 day') OVERLAPS (:startdate::DATE, :enddate::DATE + INTERVAL '1 day')");
    $sth->bindParam(':hotel', $hotelName, PDO::PARAM_STR, strlen($hotelName));
    $sth->bindParam(':room', $roomName, PDO::PARAM_STR, strlen($roomName));
    $sth->bindParam(':startdate', $startDateChosen, PDO::PARAM_STR, strlen($startDateChosen));
    $sth->bindParam(':enddate', $endDateChosen, PDO::PARAM_STR, strlen($endDateChosen));
    if (!$sth->execute())
      throw new Exception("An error occurred");
    if (!empty($sth->fetch(PDO::FETCH_NUM))) {
      header("location: ../error.php?error=".urlencode('<p>Your booking overlaps with someone else\'s booking. Go back and retry.</p>'));
      die();
    }

    //echo "<p>parameters correct</p><p>adding booking to database</p>";
    $conn1 = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $sth1 = $conn1->prepare('INSERT INTO bookings
    (bookedby, roomname, hotelname, startd, endd)
    VALUES
    (:bookedby, :roomname, :hotelname, :startd, :endd);');
    echo "$bookedBy, $roomName, $hotelName, $startDateChosen, $endDateChosen";
    $sth1->bindParam(':bookedby', $bookedBy, PDO::PARAM_STR, strlen($bookedBy));
    $sth1->bindParam(':roomname', $roomName, PDO::PARAM_STR, strlen($roomName));
    $sth1->bindParam(':hotelname', $hotelName, PDO::PARAM_STR, strlen($hotelName));
    $sth1->bindParam(':startd', $startDateChosen, PDO::PARAM_STR, strlen($startDateChosen));
    $sth1->bindParam(':endd', $endDateChosen, PDO::PARAM_STR, strlen($endDateChosen));
    $sth1->execute();
    //echo "<p>added booking to database</p>";
    header("location: ../notifications.php ");

  } catch (PDOException $e) {
    header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
    die();
  } catch (Exception $e) {
    header("location: ../error.php?error=".urlencode($e->getMessage().'<p>An error occurred. Go back and retry.</p>'));
    die();
  }
  
?>