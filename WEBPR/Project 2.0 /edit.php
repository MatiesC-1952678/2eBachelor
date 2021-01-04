<?php
  session_start();
  require 'php/reusables.php';
  $key1 = $_GET["key1"];
  $key2 = $_GET["key2"];
  $key3 = $_GET["key3"];
  $type = $_GET["type"];
  $user = $_SESSION["name"];
  $admin = $_SESSION["admin"];
  //USE IN OTHER PLACES!
  if ($user != $key1 && $key1 != "") {
    if ($admin != true) {
      echo '<p> not your account </p>';
      die();
    }
  }
  checkSession($_SESSION["typeLogged"], "", true, "php/logOut.php", "You need to be logged to enter this page");
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Edit</title>
  <meta charset="utf-8">
  <meta name="description" content="A platform for hotels and customers to easily meet">
  <meta name="keywords" content="Room,Country,Hotel,Book">
  <meta name="author" content="Maties Claesen">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="css/management.css">
</head>

<body>
  <!-- Page Container -->
  <div id="PageContainer">

    <?php include("php/header.php") ?>

    <!-- Main Content -->
    <div class="MainContent">
        <?php
            switch ($type) {
                case "hotel":
                    echo '<div id="List">';
                    showHotels("SELECT * FROM hotels WHERE hotels.name = :enterprise", $key2, "Booking", "Booking-Title");
                    echo '</div>';
                    include('html/hotelEditForm.php');
                    break;
                case "room":
                    echo '<div id="List">';
                    showSingleRoomAndHotel($key3, $key2);
                    echo '</div>';
                    include('html/roomEditForm.php');
                    break;
                case "user":
                    echo '<div id="List">';
                    showUsers("SELECT * FROM users WHERE users.username = :search", $key2, "Room", "Room-Title", true, true);
                    echo '</div>';
                    include('html/userEditForm.php');
                    break;
                case "enterprise":
                    echo '<div id="List">';
                    showUsers("SELECT * FROM enterprises WHERE enterprises.name = :search", $key2, "Room", "Room-Title", false, true);
                    echo '</div>';
                    include('html/enterpriseEditForm.php');
                    break;
                default:
                    break;
            }
        ?>
    </div>

    <?php include("php/footer.php") ?>

  </div>
</body>
</html>
