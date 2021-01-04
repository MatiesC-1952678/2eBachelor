<!-- Hotel Edit Form -->
<p> here you can edit the hotel you have chosen </p>
<h1> Keep the textfields empty for values you don't want to change: </h1>
<form id="uploadHotelFormS" action="uploads/updateHotel.php?original=<?php echo urlencode($key2) ?>&enterprise=<?php echo urlencode($key1) ?>" method="post">
    <label for="hotelName">The name of your hotel:</label>
    <input type="text" id="hotelName" name="hotelName" value="" onblur="checkEditHotel()">
    <label for="hotelDescription">Description of your hotel (max 200 characters):</label>
    <input type="text" id="hotelDescription" name="hotelDescription" value="" onblur="checkEditHotel()">
    <p> your start and end time of the availability of your hotel:</p>
    <label for="startDate">starting date</label>
    <input type="date" name="startDate" id="startDate" onblur="checkEditHotel()">
    <label for="endDate">ending date</label>
    <input type="date" name="endDate" id="endDate" onblur="checkEditHotel()">
    <p> the openinghours of your hotel/hotel </p>
    <label for="startTime">the hour when the hotel opens</label>
    <input type="time" name="startTime" id="startTime" onblur="checkEditHotel()">
    <label for="endTime">the hour when the hotel closes</label>
    <input type="time" name="endTime" id="endTime" onblur="checkEditHotel()">
    <?php
        showRadioCountries(false);
    ?>
    <input type="submit" name="submit" value="Upload hotel" onmouseover="checkEditHotel()">
</form>
<script type="text/javascript" src="javascript/management.js"></script>