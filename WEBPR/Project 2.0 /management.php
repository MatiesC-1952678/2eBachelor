<?php
  session_start();
  require 'php/globals.php';
  require 'php/reusables.php';
  checkSession($_SESSION["name"], "enterprise", true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Management</title>
  <meta charset="utf-8">
  <meta name="description" content="A platform for hotels and customers to easily meet">
  <meta name="keywords" content="Enterprise,Country,Hotel,hotels,Book">
  <meta name="author" content="Maties Claesen">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/account.css">
  <script type="text/javascript" src=""></script>

</head>


<body>
  <!-- Page Container -->
  <div id="PageContainer">

    <?php include("php/header.php") ?>

      <div id="List">
        <p>All your hotels you've posted publicly</p>
        <?php
        showHotels("SELECT * FROM hotels WHERE hotels.belongstoenterprise = :enterprise", $_SESSION["name"], "Booking", "Booking-Title", true);
        ?>
      </div>

      <div class="boxed"><p>Here you can add a new hotel (linked to this hotel)</p>
        <form id="UploadhotelForm" action="uploads/uploadHotel.php" method="post" enctype="multipart/form-data">
            <label for="hotelName">The name of your hotel:</label>
            <input type="text" id="hotelName" name="hotelName" value="">
            <label for="hotelDescription">Description of your hotel (max 200 characters):</label>
            <input type="text" id="hotelDescription" name="hotelDescription" value="">
            <p> your start and end time of the availability of your hotel:</p>
            <label for="startDate">starting date</label>
            <input type="date" name="startDate" id="startDate">
            <label for="endDate">ending date</label>
            <input type="date" name="endDate" id="endDate">
            <p> the openinghours of your hotel/hotel </p>
            <label for="startTime">the hour when the hotel opens</label>
            <input type="time" name="startTime" id="startTime">
            <label for="endTime">the hour when the hotel closes</label>
            <input type="time" name="endTime" id="endTime">
            <?php
                showRadioCountries();
            ?>
            <label>Select an image that you want upload (you can add multiple in a row): (jpeg)</label>
            <input type="file" name="imageToUpload" accept="image/jpeg">
            <input type="submit" name="submit" value="Upload hotel">
        </form>
    </div>

    <div id="List">
      <p>All your rooms you've posted publicly</p>
      <?php
        showRooms("SELECT * FROM hotels,rooms WHERE hotels.belongstoenterprise = :name AND rooms.belongstohotel = hotels.name", $_SESSION["name"], "Booking", "Booking-Title", false, false, true);
      ?>
    </div>
    <div class="boxed"><p>Here you can add a new room (linked to this room)</p>
        <form id="UploadRoomForm" action="uploads/uploadRoom.php" method="post" enctype="multipart/form-data">
            <?php
                showRadioHotels($_SESSION["name"]);
            ?>
            <label for="roomName">The name of your room:</label>
            <input type="text" id="roomName" name="roomName" value="">
            <label for="roomDescription">Description of your room (max 200 characters):</label>
            <input type="text" id="roomDescription" name="roomDescription" value="">
            <label for="cost">the cost per day</label>
            <input type="number" id="cost" name="cost" min="0" max="100000" value="100">
            
            <label for="startdate"> start date:</label>
            <input id="startdate" type="date" name="startdate">
            <label for="enddate"> end date:</label>
            <input id="enddate" type="date" name="enddate">
            <label for="timeslotmax">the max timeslot length</label>
            <input id="timeslotmax" name="timeslotmax" type="number" min="1" max="1200" value="5">

            <label>Select an image that you want upload (you can add multiple in a row): (jpeg)</label>
            <input type="file" name="imageToUpload" accept="image/jpeg">
            <input type="submit" name="submit" value="Upload Room">
        </form>
    </div>

    <div class="boxed">
        <p>Here you can add a new country</p>
        <form id="UploadCountryForm" action="uploads/uploadCountry.php" method="post" enctype="multipart/form-data">
            <label for="countryName">The name of your country:</label>
            <input type="text" id="countryName" name="countryName" value="">
            <label for="countryDescription">Description of your country (max 200 characters):</label>
            <input type="text" id="countryDescription" name="countryDescription" value="">
            <label>Select an image that you want upload (you can add multiple in a row): (jpg, jpeg, png)</label>
            <input type="file" name="imageToUpload" accept="image/jpeg,image/jpg,image/png">
            <input type="submit" name="submit" value="Upload Country">
        </form>
    </div>

    <div id="Booking-Title">
    <p>All user bookings</p>
      <?php
        //TODO: ADD ALL BOOKINGS
      ?>
    </div>
    <?php include("php/footer.php") ?>

  </div>
</body>
</html>

<?php
/*
<label for="cost">the cost per day</label>
<input type="number" id="cost" name="cost" min="0" max="100000" value="100">
*/
?>
