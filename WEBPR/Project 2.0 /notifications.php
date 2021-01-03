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
                $newDes = $description.' <a href="rating.php?room='.urlencode($row[1]).'&hotel='.urlencode($row[2]).'"> Rate the '.$row[1].' from the '.$row[2].' hotel </a>';
                uploadNotification($user, $newDes, date('Y-m-d'), date('H:i:s'), $row[1], $row[2]);
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die(); 
        }
    }

    function uploadNotification($name, $description, $date, $time, $room, $hotel) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("INSERT INTO notifications VALUES(:sentto, :description, :date, :time, :room, :hotel);");
            $sth->bindParam(':sentto', $name, PDO::PARAM_STR);
            $sth->bindParam(':description', $description, PDO::PARAM_STR);
            $sth->bindParam(':date', $date, PDO::PARAM_STR);
            $sth->bindParam(':time', $time, PDO::PARAM_STR);
            $sth->bindParam(':room', $room, PDO::PARAM_STR);
            $sth->bindParam(':hotel', $hotel, PDO::PARAM_STR);
            if ($sth->execute()) {
                echo "succesfully added notification";
            }
            //echo "$name $description $date $time $room $hotel";
            //header("location: notifications.php");
        } catch (PDOException $e) {
        print "Error! " . $e->getMessage() . "\n";
        die();
        } catch (Exception $e) {
        print "Error! " . $e->getMessage() . "\n";
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
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript" src=""></script>
</head>

<body>
  <!-- Page Container -->
  <div id="PageContainer">

    <?php include("php/header.php") ?>

    <!-- Notifications -->
    <div>
      <p>All your bookings</p>
      <div id="List">
        <!-- Bookings -->
        <?php showRooms("SELECT * FROM bookings,hotels,rooms WHERE bookings.bookedby = :name AND bookings.roomname = rooms.name AND bookings.hotelname = rooms.belongstohotel AND belongstohotel = hotels.name", $_SESSION["name"], "RoomNonFloat", "Booking-Title", false, true); ?>
      </div>
      <p>All your interests/likes</p>
      <div id="List">
        <!-- Interests -->
        <?php showRooms("SELECT * FROM likes,hotels,rooms WHERE likes.likedby = :name AND likes.room = rooms.name AND likes.hotel = rooms.belongstohotel AND rooms.belongstohotel = hotels.name", $_SESSION["name"], "Room", "Room-Title", true); ?>
      </div>
      <p>All your notifications</p>
      <div id="List">
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
