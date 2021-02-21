<p class="title"> here you can edit the room you have chosen </p>
<p> Keep the textfields empty for values you don't want to change: </p>
<form id="uploadRoomFormS" action="uploads/updateRoom.php" method="post">
    <input type="hidden" name="hotel" value="<?php echo $key2?>">
    <input type="hidden" name="original" value="<?php echo $key3?>">
    <?php
        showRadioHotels($key1, false);
    ?>
    <label for="roomName">The name of your room:</label>
    <input type="text" id="roomName" name="roomName" value="" onblur="checkEditRoom()">
    <label for="roomDescription">Description of your room (max 200 characters):</label>
    <input type="text" id="roomDescription" name="roomDescription" value="" onblur="checkEditRoom()">
    <label for="cost">the cost per day</label>
    <input type="number" id="cost" name="cost" min="0" max="9999999999" onblur="checkEditRoom()">
    <!-- Map get Long and Lat form -->
    <label> the address of your room (either longitude and latidude or an address):</label>
    <div id='map'></div>
    <p id='lnglat'></p>
    <input type="hidden" id="longInput" name="long" value="">
    <input type="hidden" id="latInput" name="lat" value="">
    <input type="submit" name="submit" value="Upload Room" onmouseover="checkEditRoom()">
</form>
<p> 
    If you want to change you starting date, ending date or timeslot you have to delete your room resulting in all your bookings being cancelled. 
    The reason being: previous bookings can not overlap with your new dates and/or timeslot. Write down your room details before deleting!
</p>
<script src="javascript/management.js"></script>
<script src="javascript/map.js"></script>