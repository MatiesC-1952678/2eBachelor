<?php
  session_start();
  require 'php/reusables.php';
  checkSession($_SESSION["typeLogged"], "user", false, "php/logOut.php", "You need to be logged in as a user to make a booking");
  $room = $_GET["roomName"];
  $hotel = $_GET["hotelName"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Booking</title>
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
    <?php
      $results = showSingleRoomAndHotel($room, $hotel);
      $array = explode(" ", $results);
      if ($array[0] == "")
        $timeslot = "null";
      else 
        $timeslot = $array[0];
      $startDate = $array[1];
      $endDate = $array[2];
    ?>
    <div id="List">
      <p> All the other bookings for this room (meaning you can't book on these time periods)</p>
      <?php showBookings("SELECT * FROM bookings WHERE roomname = :room AND hotelname = :hotel", $room, $hotel) ?>
    </div>
    <p> Make sure you don't book over someone else's booking because this will result in an error when making the booking! </p>
    <form action="uploads/uploadBooking.php" method="post" id="formS">
      <input type="hidden" name="roomName" value="<?php echo $_GET["roomName"]?>">
      <input type="hidden" name="hotelName" value="<?php echo $_GET["hotelName"]?>">
      <label for="startDate">The date you want to start booking your room</label>
      <input type="date" id="startDate" name="startDate" value="" onblur="checkBooking(<?php echo $timeslot.',\''.$startDate.'\',\''.$endDate.'\''?>)">
      <label for="endDate">The date you want to stop booking your room</label>
      <input type="date" id="endDate" name="endDate" value="" onblur="checkBooking(<?php echo $timeslot.',\''.$startDate.'\',\''.$endDate.'\''?>)">
      <input type="submit" name="submit" value="Reserve Room">
    </form>
    <?php include("php/footer.php") ?>
  </div>
  <script type="text/javascript" src="javascript/booking.js"></script>
</body>
</html>
