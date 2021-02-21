<!-- Hotel Edit Form -->
<p class="title"> here you can edit the hotel you have chosen </p>
<p class="title"> Keep the textfields empty for values you don't want to change: </p>
<form id="uploadHotelFormS" action="uploads/updateHotel.php" method="post">
    <input type="hidden" name="original" value="<?php echo $key2 ?>">
    <input type="hidden" name="enterprise" value="<?php echo $key1 ?>">
    <label for="hotelName">The name of your hotel:</label>
    <input type="text" id="hotelName" name="hotelName" value="" onblur="checkEditHotel()">
    <label for="hotelDescription">Description of your hotel (max 200 characters):</label>
    <input type="text" id="hotelDescription" name="hotelDescription" value="" onblur="checkEditHotel()">
    <p> your start and end time of the availability of your hotel:</p>
    <label for="startDate">starting date</label>
    <input type="date" name="startDate" id="startDate" onblur="checkEditHotel()" ><!-- placeholder="YYYY-MM-DD" placeholder for safari -->
    <label for="endDate">ending date</label>
    <input type="date" name="endDate" id="endDate" onblur="checkEditHotel()" ><!-- placeholder="YYYY-MM-DD" placeholder for safari -->
    <p> the openinghours of your hotel/hotel </p>
    <label for="startTime">the hour when the hotel opens</label>
    <input type="time" name="startTime" id="startTime" onblur="checkEditHotel()" ><!-- placeholder="YYYY-MM-DD" placeholder for safari -->
    <label for="endTime">the hour when the hotel closes</label>
    <input type="time" name="endTime" id="endTime" onblur="checkEditHotel()" ><!-- placeholder="YYYY-MM-DD" placeholder for safari -->
    <?php
        showRadioCountries(false);
    ?>
    <input type="submit" name="submit" value="Upload hotel" onmouseover="checkEditHotel()">
</form>
<script src="javascript/management.js"></script>