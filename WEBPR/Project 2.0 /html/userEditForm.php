<p class="title"> here you can edit the user you have chosen </p>
<h1> Keep the textfields empty for values you don't want to change: </h1>
<form id="userS" action="uploads/updateUser.php" method="post">
    <input type="hidden" name="original" value="<?php echo $key1 ?>">
    <label for="username">Username: Your username (must be in between 5 and 30 characters long and must not be taken):</label>
    <input id="username" type="text" name="username" value="" onblur="checkEditUser()">
    <label for="email">E-mail: (must be valid and between 5 and 50 characters):</label>
    <input id="email" type="email" name="email" value="" onblur="checkEditUser()">
    <label for="password">Password: (must be between 5 and 50 char)</label>
    <input id="password" type="text" name="password" value="" onblur="checkEditUser()">
    <input id="loginButton" type="submit" name="" value="register/login" onmouseover="checkEditUser()">
</form>
<link rel="stylesheet" href="css/login.css">
<script type="text/javascript" src="javascript/login.js"></script>