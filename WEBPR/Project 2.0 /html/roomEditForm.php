<p> here you can edit the room you have chosen </p>
<h1> Keep the textfields empty for values you don't want to change: </h1>
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
    <input type="number" id="cost" name="cost" min="0" max="9999999999" value="100" onblur="checkEditRoom()">
    <input type="submit" name="submit" value="Upload Room" onmouseover="checkEditRoom()">
</form>
<p> 
    If you want to change you starting date, ending date or timeslot you have to delete your room resulting in all your bookings being cancelled. 
    The reason being that previous bookings can not overlap with your new dates and timeslot. Write down your room details before deleting!
</p>
<script type="text/javascript" src="javascript/management.js"></script>