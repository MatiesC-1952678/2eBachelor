<?php
  session_start();
  require 'php/reusables.php';
  checkSession($_SESSION["typeLogged"], "user", false, "php/logOut.php", "You need to be logged in as a user to send messages");
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Chat Messages</title>
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

    <!-- Main Content -->
    <div class="MainContent">
    <?php include("html/userSearchbar.html"); ?>
      <!-- List -->
      <div class="List">
        <?php 
        if (!isset($_POST["search"])) {
            showUsers("SELECT * FROM users", "", "Room", "Room-Title");      
        } else {
            showUsers("SELECT * FROM users WHERE LOWER(users.username) LIKE :search;", $_POST["search"], "Room", "Room-Title");
        }
        ?>
      </div>
    </div>

    <?php include("php/footer.php") ?>

  </div>
  <script src="javascript/chat.js"></script>
</body>
</html>