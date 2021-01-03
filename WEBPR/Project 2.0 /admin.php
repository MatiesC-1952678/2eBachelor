<?php
  session_start();
  require 'php/reusables.php';
  if ($_SESSION["admin"] == true) 
        $url = "../admin.php";
  else {
    echo "<p>page does not exist</p>";
    die();
  }
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - ADMIN</title>
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

    <!-- Main Content -->
    <div class="MainContent">
      <h1> all enterprises on the website </h1>
      <div id="List">
          <?php 
            showUsers("SELECT * FROM enterprises", "", "Room", "Room-Title", false, true);
          ?>
      </div>
      <h1> all hotels on the website </h1>
      <div id="List">
          <?php 
            showHotels("SELECT * FROM hotels", "", "Room", "Room-Title", true);
          ?>
      </div>
      <h1> all rooms on the website </h1>
      <div id="List">
          <?php 
            showRooms("SELECT * FROM hotels,rooms WHERE hotels.name = rooms.belongstohotel", "", "Room", "Room-Title", false, false, true);
          ?>
      </div>
      <h1> all users on the website </h1>
      <div id="List">
          <?php 
            showUsers("SELECT * FROM users", "", "Room", "Room-Title", true, true);
          ?>
      </div>
    </div>

    <?php include("php/footer.php") ?>

  </div>
</body>
</html>