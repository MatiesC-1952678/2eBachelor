<?php
  session_start();
  $room = $_GET["room"];
  $hotel = $_GET["hotel"];
  require 'php/reusables.php';
  if (!isset($room) || !isset($hotel)) {
    echoError();
    die();
  }
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Rating</title>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html"/>
  <meta name="description" content="A platform for hotels and customers to easily meet">
  <meta name="keywords" content="Room,Country,Hotel,Book">
  <meta name="author" content="Maties Claesen">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/error.css">
</head>

<body>
  <!-- Page Container -->
  <div id="PageContainer">

    <?php include("php/header.php") ?>

    <!-- Main Content -->
    <div class="MainContent">
        <?php showSingleRoomAndHotel($room, $hotel); ?>
        <p class="title"> Your Rating </p>
        <div id="formS">
          <form action="uploads/uploadRating.php" method="post">
            <input type="hidden" name="user" value="<?php echo $_SESSION["name"]?>">
            <input type="hidden" name="room" value="<?php echo $room?>">
            <input type="hidden" name="hotel" value="<?php echo $hotel?>">
            <label for="review">review (max 200 characters):</label>
            <input id="review" name="review" type="text" value="" placeholder="review comes here" onblur="checkMinMax('review',0,200,'formS','formW','Your description is too long')">
            <label for="rating">how many stars (min = 0 and max = 5):</label>
            <input id="rating" name="rating" type="number" min="0" max="5" value="1" onblur="checkMinMax('rating',0,5,'formS','formW','Your star count is not in the range',false)">
            <input type="submit" value="upload rating">
          </form>
        </div>
        <?php echo '<p class="title"> Ratings </p>'; showRatings($room, $hotel); ?>
    </div>

    <?php include("php/footer.php") ?>

  </div>
  <script src="javascript/inputChecks.js"></script>
</body>
</html>