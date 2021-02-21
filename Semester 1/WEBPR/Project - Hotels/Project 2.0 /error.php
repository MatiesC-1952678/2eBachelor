<?php
  session_start();
  $errorCode = $_GET["error"];
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Error</title>
  <meta charset="utf-8">
  <meta name="description" content="A platform for hotels and customers to easily meet">
  <meta name="keywords" content="Room,Country,Hotel,Book">
  <meta name="author" content="Maties Claesen">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/error.css">
</head>

<body>
  <!-- Page Container -->
  <div id="PageContainer">

    <?php include("php/header.php") ?>

    <!-- Main Content -->
    <div class="ErrorPage">
        <?php
            echo $errorCode;
        ?>
        <input id="backButton" type="button" value="Go back!" onclick="history.back()">
    </div>

    <?php include("php/footer.php") ?>

  </div>
</body>
</html>
