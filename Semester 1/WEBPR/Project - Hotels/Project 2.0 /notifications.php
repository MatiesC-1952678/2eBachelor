<?php
  session_start();
  require 'php/reusables.php';
  //DUPLICATES BECAUSE OF WRONG INCLUSION OTHERWISE
  function notifyBookings($user, $current, $description) {
        try {
            $conn = new PDO("pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("SELECT * FROM bookings WHERE bookedby = :user AND endd < (:current::date)");
            $sth->bindParam( ':user', $user, PDO::PARAM_STR, strlen($user));
            $sth->bindParam( ':current', $current, PDO::PARAM_STR, strlen($current));
            if (!$sth->execute())
                echo "unsuccesfully queried bookings";
            while ($row = $sth->fetch(PDO::FETCH_NUM)) {
                $newDes = $description.' <a href="rating.php?room='.urlencode($row[1]).'&hotel='.urlencode($row[2]).'"> Rate this room </a>';
                uploadNotification($row[0], $newDes, $row[1], $row[2], date('Y-m-d H:i:s'));
            }
        } catch (PDOException $e) {
          header("location: error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
          die();
        }
    }

    function uploadNotification($name, $description, $room, $hotel, $time) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("INSERT INTO notifications VALUES(:sentto, :description, :room, :hotel, :time);");
            $sth->bindParam(':sentto', $name, PDO::PARAM_STR, strlen($name));
            $sth->bindParam(':description', $description, PDO::PARAM_STR, strlen($description));
            $sth->bindParam(':time', $time, PDO::PARAM_STR, strlen($time));
            $sth->bindParam(':room', $room, PDO::PARAM_STR, strlen($room));
            $sth->bindParam(':hotel', $hotel, PDO::PARAM_STR, strlen($hotel));
            if ($sth->execute()) {
                echo "succesfully added notification";
            }
            //echo "$name $description $date $time $room $hotel";
            //header("location: notifications.php");
        } catch (PDOException $e) {
          header("location: error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
          die();
        } catch (Exception $e) {
          header("location: error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
          die();
        }
    }
  checkSession($_SESSION["typeLogged"], "user", false);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Notifications</title>
  <meta charset="utf-8">
  <meta name="description" content="A platform for hotels and customers to easily meet">
  <meta name="keywords" content="Room,Country,Hotel,Book">
  <meta name="author" content="Maties Claesen">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- Page Container -->
  <div id="PageContainer">

    <?php include("php/header.php") ?>

    <!-- Notifications -->
    <div>
      <p class="title">All your bookings</p>
      <div class="List">
        <!-- Bookings -->
        <?php showRooms("SELECT *, hotels.startdate AS hotelstart, hotels.enddate AS hotelend FROM bookings,hotels,rooms WHERE bookings.bookedby = :name AND bookings.roomname = rooms.name AND bookings.hotelname = rooms.belongstohotel AND belongstohotel = hotels.name", $_SESSION["name"], "RoomNonFloat", "Booking-Title", false, true); ?>
      </div>
      <p class="title">All your interests/likes</p>
      <div class="List">
        <!-- Interests -->
        <?php showRooms("SELECT * FROM likes,hotels,rooms WHERE likes.likedby = :name AND likes.room = rooms.name AND likes.hotel = rooms.belongstohotel AND rooms.belongstohotel = hotels.name", $_SESSION["name"], "Room", "Room-Title", true); ?>
      </div>
      <p class="title">All your notifications</p>
      <div class="List">
        <!-- UserNotifications -->
        <?php 
        notifyBookings($_SESSION["name"], date('Y-m-d'), "How was your stay at the last room you stayed in?", true);
        showNotifications();
        pdo("DELETE FROM bookings WHERE bookedby = :key1 AND endd < (:key2::date)", $_SESSION["name"], date('Y-m-d'));
        ?>
      </div>
    </div>

    <?php include("php/footer.php") ?>

  </div>
</body>
</html>
