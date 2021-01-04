<?php
  session_start();
  require 'php/globals.php';
  require 'php/reusables.php';
  checkSession($_SESSION["typeLogged"], "enterprise", false);
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
  <link rel="stylesheet" href="css/management.css">
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
        <form id="uploadHotelFormS" action="uploads/uploadHotel.php" method="post" enctype="multipart/form-data">
            <label for="hotelName">The name of your hotel:</label>
            <input type="text" id="hotelName" name="hotelName" value="" onblur="checkAllHotel()">
            <label for="hotelDescription">Description of your hotel (max 200 characters):</label>
            <input type="text" id="hotelDescription" name="hotelDescription" value="" onblur="checkAllHotel()">
            <p> your start and end time of the availability of your hotel:</p>
            <label for="startDate">starting date</label>
            <input type="date" name="startDate" id="startDate" onblur="checkAllHotel()">
            <label for="endDate">ending date</label>
            <input type="date" name="endDate" id="endDate" onblur="checkAllHotel()">
            <p> the openinghours of your hotel/hotel </p>
            <label for="startTime">the hour when the hotel opens</label>
            <input type="time" name="startTime" id="startTime" onblur="checkAllHotel()">
            <label for="endTime">the hour when the hotel closes</label>
            <input type="time" name="endTime" id="endTime" onblur="checkAllHotel()">
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
        <form id="uploadRoomFormS" action="uploads/uploadRoom.php" method="post" enctype="multipart/form-data">
            <?php
                showRadioHotels($_SESSION["name"]);
            ?>
            <label for="roomName">The name of your room:</label>
            <input type="text" id="roomName" name="roomName" value="" onblur="checkAllRoom()">
            <label for="roomDescription">Description of your room (max 200 characters):</label>
            <input type="text" id="roomDescription" name="roomDescription" value="" onblur="checkAllRoom()">
            <label for="cost">the cost per day</label>
            <input type="number" id="cost" name="cost" min="0" max="9999999999" value="100" onblur="checkAllRoom()">
            
            <label for="startdate"> start date (make sure that your start and end date are both in between the available time of the hotel you are selecting or you will get an error while uploading):</label>
            <input id="startdate" type="date" name="startdate" onblur="checkAllRoom()">
            <label for="enddate"> end date:</label>
            <input id="enddate" type="date" name="enddate" onblur="checkAllRoom()">
            <label for="timeslotmax">the max timeslot length</label>
            <input id="timeslotmax" name="timeslotmax" type="number" min="1" max="9999999999" value="5" onblur="checkAllRoom()">

            <label>Select an image that you want upload (you can add multiple in a row): (jpeg)</label>
            <input type="file" name="imageToUpload" accept="image/jpeg">
            <input type="submit" name="submit" value="Upload Room" onmouseover="checkAllRoom()">
        </form>
    </div>

    <div class="boxed">
        <p>Here you can add a new country</p>
        <form id="UploadCountryFormS" action="uploads/uploadCountry.php" method="post" enctype="multipart/form-data">
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
<script type="text/javascript" src="javascript/management.js"></script>
</body>
</html>
