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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/management.css">
</head>


<body>
  <!-- Page Container -->
  <div id="PageContainer">

    <?php include("php/header.php") ?>

      <div class="List">
        <p class="title">All your hotels you've posted publicly</p>
        <?php
          showHotels("SELECT * FROM hotels WHERE hotels.belongstoenterprise = :enterprise", $_SESSION["name"], "Booking", "Booking-Title", true);
        ?>
      </div>

      <div class="boxed form"><p>Here you can add a new hotel (linked to this hotel)</p>
        <form id="uploadHotelFormS" action="uploads/uploadHotel.php" method="post" enctype="multipart/form-data">
            <label for="hotelName">The name of your hotel:</label>
            <input type="text" id="hotelName" name="hotelName" value="" onblur="checkAllHotel()">
            <label for="hotelDescription">Description of your hotel (max 200 characters):</label>
            <input type="text" id="hotelDescription" name="hotelDescription" value="" onblur="checkAllHotel()">
            <p> your start and end time of the availability of your hotel:</p>
            <label for="startDate">starting date</label>
            <input type="date" name="startDate" id="startDate" onblur="checkAllHotel()" placeholder="YYYY-MM-DD" ><!-- placeholder for safari -->
            <label for="endDate">ending date</label>
            <input type="date" name="endDate" id="endDate" onblur="checkAllHotel()" placeholder="YYYY-MM-DD" ><!-- placeholder for safari -->
            <p> the openinghours of your hotel/hotel </p>
            <label for="startTime">the hour when the hotel opens</label>
            <input type="time" name="startTime" id="startTime" onblur="checkAllHotel()"placeholder="hh:mm" ><!-- placeholder for safari -->
            <label for="endTime">the hour when the hotel closes</label>
            <input type="time" name="endTime" id="endTime" onblur="checkAllHotel()"placeholder="hh:mm" ><!-- placeholder for safari -->
            <?php
                showRadioCountries();
            ?>
            <!-- Upload Image Form -->
            <label>Select an image that you want upload (you can add multiple): (jpg, jpeg, png)</label>
            <input type="file" name="imagesToUpload[]" accept="image/jpeg,image/jpg,image/png" multiple>
            <!-- Upload Video Form -->
            <label>Select videos that you want upload (you can add multiple): (mv4, mp4)</label>
            <input type="file" name="videosToUpload[]" accept="video/mv4,video/mp4" multiple>
            <input type="submit" name="submit" value="Add Hotel" onmouseover="checkAllHotel()">
        </form>
    </div>

    <div class="List">
      <p class="title">All your rooms you've posted publicly</p>
      <?php
        showRooms("SELECT * FROM hotels,rooms WHERE hotels.belongstoenterprise = :name AND rooms.belongstohotel = hotels.name", $_SESSION["name"], "Booking", "Booking-Title", false, false, true);
      ?>
    </div>
    <div class="boxed form"><p>Here you can add a new room (linked to this room)</p>
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
            <input id="startdate" type="date" name="startdate" onblur="checkAllRoom()" placeholder="YYYY-MM-DD" ><!-- placeholder for safari -->
            <label for="enddate"> end date:</label>
            <input id="enddate" type="date" name="enddate" onblur="checkAllRoom()" placeholder="YYYY-MM-DD" ><!-- placeholder for safari -->
            <label for="timeslotmax">the max timeslot length</label>
            <input id="timeslotmax" name="timeslotmax" type="number" min="1" max="9999999999" value="5" onblur="checkAllRoom()">

            <!-- Upload Image Form -->
            <label>Select an image that you want upload (you can add multiple): (jpg, jpeg, png)</label>
            <input type="file" name="imagesToUpload[]" accept="image/jpeg,image/jpg,image/png" multiple>
            <!-- Upload Video Form -->
            <label>Select videos that you want upload (you can add multiple): (mv4, mp4)</label>
            <input type="file" name="videosToUpload[]" accept="video/mv4,video/mp4" multiple>
            <input type="submit" name="submit" value="Add Room" onmouseover="checkAllRoom()">
        </form>
    </div>

    <div class="List">
      <p class="title">All user bookings</p>
        <?php
          showBookings("SELECT * FROM bookings,hotels WHERE hotels.belongstoenterprise = :room AND hotels.name = bookings.hotelname", $_SESSION["name"], "");
        ?>
    </div>

    <div class="boxed form">
        <p>Here you can add a new country</p>
        <form id="uploadCountryFormS" action="uploads/uploadCountry.php" method="post" enctype="multipart/form-data">
            <label for="countryName">The name of your country:</label>
            <input type="text" id="countryName" name="countryName" value="" onblur="checkCountry()">
            <label for="countryDescription">Description of your country (max 200 characters):</label>
            <input type="text" id="countryDescription" name="countryDescription" value="" onblur="checkCountry()">
            <input type="submit" name="submit" value="Add Country" onmouseover="checkCountry()">
        </form>
    </div>

    <?php include("php/footer.php") ?>

  </div>
<script type="text/javascript" src="javascript/management.js"></script>
</body>
</html>
