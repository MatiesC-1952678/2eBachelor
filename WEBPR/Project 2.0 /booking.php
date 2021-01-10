<?php
  session_start();
  require 'php/reusables.php';
  require 'php/timeslots.php';
  checkSession($_SESSION["typeLogged"], "user", false, "error.php", "You need to be logged in as a user to make a booking");
  $room = $_GET["roomName"];
  $hotel = $_GET["hotelName"];
  $bookStart = $_GET["start"];
  $bookEnd = $_GET["end"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Booking</title>
  <meta charset="utf-8">
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
    <p> Make sure you don't book over someone else's booking because this will result in an error when making the booking! </p>
    <form action="uploads/uploadBooking.php" method="post" id="formS">
      <input type="hidden" name="roomName" value="<?php echo $room?>">
      <input type="hidden" name="hotelName" value="<?php echo $hotel?>">
      <label for="startDate">The date you want to start booking your room</label>
      <input type="date" id="startDate" name="startDate" value="<?php echo $bookStart?>" onblur="checkBooking(<?php echo $timeslot.',\''.$startDate.'\',\''.$endDate.'\''?>)">
      <label for="endDate">The date you want to stop booking your room</label>
      <input type="date" id="endDate" name="endDate" value="<?php echo $bookEnd?>" onblur="checkBooking(<?php echo $timeslot.',\''.$startDate.'\',\''.$endDate.'\''?>)">
      <input type="submit" name="submit" value="Reserve Room">
    </form>
    <?php
      $results = showSingleRoomAndHotel($room, $hotel);
      $array = explode(" ", $results);
      if (!isset($array[0]))
        $timeslot = "null";
      else 
        $timeslot = $array[0];
      $startDate = $array[1];
      $endDate = $array[2];
      if (!isset($bookStart) || !isset($bookEnd)) {
        $bookStart = $startDate;
        $bookEnd = $endDate;
      }
    ?>
    <div class="List">
      <p class="title"> All the available timeslots (these have either the max timeslot or go for 5 days at a time)</p>
      <?php showTimeslots("SELECT hotels.startdate,hotels.enddate,rooms.startdate,rooms.enddate,rooms.timeslotmax 
      FROM hotels,rooms
      WHERE rooms.name = :room AND hotels.name =:hotel AND rooms.belongstohotel = hotels.name", $room, $hotel) ?>
    </div>
    <div class="List">
      <p class="title"> All the other bookings for this room (meaning you can't book on these time periods)</p>
      <?php showBookings("SELECT * FROM bookings WHERE roomname = :room AND hotelname = :hotel", $room, $hotel) ?>
    </div>
    <?php include("php/footer.php") ?>
  </div>
  <script src="javascript/booking.js"></script>
</body>
</html>
