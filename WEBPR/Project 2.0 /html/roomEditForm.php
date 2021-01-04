<p> here you can edit the room you have chosen </p>
<h1> Keep the textfields empty for values you don't want to change: </h1>
<form id="uploadRoomFormS" action="uploads/updateRoom.php?hotel=<?php echo urlencode($key2) ?>&original=<?php echo urlencode($key3) ?>" method="post">
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