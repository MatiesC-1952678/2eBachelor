<?php
  session_start();
  require "php/reusables.php";
  //checkStayLoggedIn($_COOKIE["loggedIn"]);
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Home</title>
  <meta charset="utf-8">
  <meta name="description" content="A platform for hotels and customers to easily meet">
  <meta name="keywords" content="Room,Country,Hotel,Book">
  <meta name="author" content="Maties Claesen">
  <!-- Map Specializing -->
  <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no'>
  
  <script src='https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.js'></script>
  
  <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.css' rel='stylesheet'>
  <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.min.js'></script>
  <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.css' type='text/css' />

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/home.css">
  <style>
    #map {
       width: 80%;
       height: 300px;
       margin: auto;
       margin-bottom: 30px;
       margin-top: 30px;
    }
  </style>
</head>

<body>
  <!-- Page Container -->
  <div id="PageContainer">

    <?php include("php/header.php") ?>

    <!-- Main Content -->
    <div class="MainContent">

      <?php
      if (isset($_SESSION["typeLogged"])) {
        echo "<div id='map'></div>";
        include("html/searchbar.html");
      }
      ?>

      <!-- List -->
      <div class="List">
        <!-- Some examples of the items you could see in this list -->
        <?php 
          switch ($_POST["type"]) {
            case ("Room"):
              showSearch("SELECT * FROM hotels,rooms WHERE rooms.belongstohotel = hotels.name AND LOWER(rooms.name) LIKE :search;", $_POST["search"]);
              break;
            case ("Hotel"):
              showSearch("SELECT * FROM hotels WHERE LOWER(hotels.name) LIKE :search;", $_POST["search"], false);
              break;
            case ("User"):
              showUsers("SELECT * FROM users WHERE LOWER(users.username) LIKE :search;", $_POST["search"], "Room", "Room-Title");
              break;
            case ("Enterprise"):
              showUsers("SELECT * FROM enterprises WHERE LOWER(enterprises.name) LIKE :search;", $_POST["search"], "Room", "Room-Title", false);
              break;
            case ("Date"):
              showDateSearch("SELECT * FROM hotels,rooms WHERE rooms.belongstohotel = hotels.name AND (hotels.startdate, hotels.enddate) OVERLAPS (:date::DATE, :date::DATE);", $_POST["date"]);
              break;
            case ("DateRoom"):
              showDateSearch("SELECT * FROM hotels,rooms WHERE rooms.belongstohotel = hotels.name AND (rooms.startdate, rooms.enddate) OVERLAPS (:date::DATE, :date::DATE);", $_POST["date"]);
              break;
            case (""):
            default:
              showRooms("SELECT * FROM hotels,rooms WHERE rooms.belongstohotel = hotels.name", "", "Room", "Room-Title", true); 
              break;
          }
        ?>
      </div>
    </div>

    <?php include("php/footer.php") ?>

  </div>
  <script src="javascript/home.js"></script>
  <?php if (isset($_SESSION["typeLogged"])) { echo '<script src="javascript/map.js"></script>'; } ?>
</body>
</html>
