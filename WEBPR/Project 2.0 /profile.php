<?php
  session_start();
  require 'php/globals.php';
  require 'php/reusables.php';
  $type = $_GET["type"];
  $name = $_GET["name"];
  if (!isset($type) || !isset($name)) {
    echoError();
    die();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Profile</title>
  <meta charset="utf-8">
  <meta name="description" content="A platform for enterprises and customers to easily meet">
  <meta name="keywords" content="Room,Country,enterprise,Book">
  <meta name="author" content="Maties Claesen">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- Page Container -->
  <div id="PageContainer">

    <?php include("php/header.php"); ?>

    <!-- Main Content -->
    <div>
      <!-- AccountInfo -->
      <article class="boxed" id="AccountInfo">
        <?php
          if ($type == "user")
            showUsers("SELECT * FROM users WHERE users.username = :search", $name, "RoomNonFloat", "Room-Title", true);
          else if ($type == "enterprise")
            showUsers("SELECT * FROM enterprises WHERE enterprises.name = :search", $name, "RoomNonFloat", "Room-Title", false);
         ?>
      </article>

      <!-- Uploaded Images -->
      <div class="userImages List">
        <?php showImages($_SESSION["name"], $_SESSION["typeLogged"]); ?>
      </div>

        <?php
          if ($type == "enterprise") {
            echo '<p class="title"> Hotels from this enterprise: </p><div class="List">';
            showHotels("SELECT * FROM hotels WHERE hotels.belongstoenterprise = :enterprise", $name, "Room", "Room-Title");
            echo '</div><p class="title"> Rooms from this enterprise: </p><div class="List">';
            showRooms("SELECT * FROM hotels,rooms WHERE hotels.belongstoenterprise = :name AND rooms.belongstohotel = hotels.name", $name, "Room", "Room-Title", true);
            echo '</div>';
          } else {
            echo '<p class="title"> Bookings from this user: </p><div class="List">';
            showRooms("SELECT * FROM bookings,hotels,rooms WHERE bookedby = :name AND roomname = rooms.name AND rooms.belongstohotel = hotels.name", $name, "Room", "Booking-Title");
            echo '</div><p class="title"> Interests of this user: </p><div class="List">';
            showRooms("SELECT * FROM likes,hotels,rooms WHERE likes.likedby = :name AND rooms.name = likes.room AND rooms.belongstohotel = hotels.name", $name, "Room", "Room-Title", true);
            echo '</div>';
          }
        ?>
      </div>

      <div class="List">
      <p class="title">All user bookings</p>
        <?php
          showBookings("SELECT * FROM bookings,hotels WHERE hotels.belongstoenterprise = :room AND hotels.name = bookings.hotelname", $name, "");
        ?>
    </div>

    <?php include("php/footer.php"); ?>
    </div>
  </div>
</body>
</html>
