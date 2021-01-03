<p> here you can edit the enterprise you have chosen </p>
<h1> Keep the textfields empty for values you don't want to change: </h1>
<form action="uploads/updateEnterprise.php?original=<?php echo urlencode($key1) ?>" method="post">
    <label for="enterpriseName">The name of your enterprise:</label>
    <input type="text" id="enterpriseName" name="enterpriseName" value="" onblur="checkName()">
    <label for="enterpriseDescription">Description of your enterprise (max 200 characters):</label>
    <input type="text" id="enterpriseDescription" name="enterpriseDescription" value="" onblur="checkDescription()">
    <label for="enterpriseEmail">Your email (must be valid and less than 50 characters):</label>
    <input type="email" id="enterpriseEmail" name="enterpriseEmail" value="" onblur="checkEmail()">
    <label for="enterprisePhone">Your enterprise's phonenumber (numbers only):</label>
    <input type="phonenumber" id="enterprisePhone" name="enterprisePhone" value="" onblur="checkPhone()">
    <label for="enterprisePassword">Password: (must be between 5 and 50 char)</label>
    <input id="enterprisePassword" type="text" name="enterprisePassword" value="" onblur="checkPassword()">
    <input id="loginButton" type="submit" name="" value="register/login">
</form>