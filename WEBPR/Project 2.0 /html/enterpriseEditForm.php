<p class="title"> here you can edit the enterprise you have chosen </p>
<p class="title"> Keep the textfields empty for values you don't want to change: </p>
<form id="enterpriseS" action="uploads/updateEnterprise.php" method="post">
    <input type="hidden" name="original" value="<?php echo $key1 ?>">
    <label for="enterpriseName">The name of your enterprise:</label>
    <input type="text" id="enterpriseName" name="enterpriseName" value="" onblur="checkEditEnterprise()">
    <label for="enterpriseDescription">Description of your enterprise (max 200 characters):</label>
    <input type="text" id="enterpriseDescription" name="enterpriseDescription" value="" onblur="checkEditEnterprise()">
    <label for="enterpriseEmail">Your email (must be valid and less than 50 characters):</label>
    <input type="email" id="enterpriseEmail" name="enterpriseEmail" value="" onblur="checkEditEnterprise()">
    <label for="enterprisePhone">Your enterprise's phonenumber (numbers only):</label>
    <input type="tel" id="enterprisePhone" name="enterprisePhone" value="" onblur="checkEditEnterprise()">
    <label for="enterprisePassword">Password: (must be between 5 and 50 char)</label>
    <input id="enterprisePassword" type="text" name="enterprisePassword" value="" onblur="checkEditEnterprise()">
    <input id="loginButton" type="submit" value="register/login" onmouseover="checkEditEnterprise()">
</form>
<script src="javascript/login.js"></script>