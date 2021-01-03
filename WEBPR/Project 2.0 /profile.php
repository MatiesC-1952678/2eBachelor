<?php
  session_start();
  require 'php/globals.php';
  require 'php/reusables.php';
  $type = $_GET["type"];
  $name = $_GET["name"];
  if ($type == "" || $name == "") {
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
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript" src=""></script>
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
      <div class="userImages">
        <?php showImages($_SESSION["name"], $_SESSION["typeLogged"]); ?>
      </div>

      <div id="List">
        <?php
          if ($type == "enterprise") {
            echo '<p> Hotels from this enterprise: </p>';
            showHotels("SELECT * FROM hotels WHERE hotels.belongstoenterprise = :enterprise", $name, "Room", "Room-Title");
            echo '<p> Rooms from this enterprise: </p>';
            showRooms("SELECT * FROM hotels,rooms WHERE hotels.belongstoenterprise = :name AND rooms.belongstohotel = hotels.name", $name, "Room", "Room-Title", true);
          } else {
            echo '<p> Bookings from this user: </p>';
            showRooms("SELECT * FROM bookings,hotels,rooms WHERE bookedby = :name AND roomname = rooms.name AND rooms.belongstohotel = hotels.name", $name, "Room", "Booking-Title");
            echo '<p> Interests of this user: </p>';
            showRooms("SELECT * FROM likes,hotels,rooms WHERE likes.likedby = :name AND rooms.name = likes.room AND rooms.belongstohotel = hotels.name", $name, "Room", "Room-Title", true);
          }
        ?>
      </div>

    <?php include("php/footer.php"); ?>
    </div>
  </div>
</body>
</html>
