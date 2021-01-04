<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Login</title>
  <meta charset="utf-8">
  <meta name="description" content="A platform for enterprises and customers to easily meet">
  <meta name="keywords" content="Room,Country,enterprise,Book">
  <meta name="author" content="Maties Claesen">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/login.css">
</head>

<body>
<!-- Page Container -->
<div id="PageContainer">

  <?php include("php/header.php") ?>

    <!-- Login -->
    <div class="loginPage">
      <form class="radioButtons" action="" method="post">
          <!--- user or enterprise choice --->
          <p>Do you want to register as a User or as a enterprise?</p>
          <input type="radio" id="customer" name="typeOfUser" value="customer" onclick="showElements()">
          <label for="customer">User</label>
          <input type="radio" id="enterprise" name="typeOfUser" value="enterprise" onclick="showElements()">
          <label for="enterprise">Enterprise</label>
      </form>
        <!--- user login --->
      <form class="userLogin" action="php/userLogin.php" method="post">
        <div id="userH">
          <label for="username">Username: Your username (between 5 and 30 characters and not be taken):</label>
          <input id="username" type="text" name="username" value="" onblur="checkAllUser()">
          <label for="email">E-mail: (must be valid and between 5 and 50 characters):</label>
          <input id="email" type="email" name="email" value="" onblur="checkAllUser()">
          <label for="password">Password (must be between 5 and 50 char):</label>
          <input id="password" type="text" name="password" value="" onblur="checkAllUser()">
          <input id="loginButton" type="submit" name="" value="register/login" onmouseover="checkAllUser()">
        </div>
      </form>
        <!--- enterprise login --->
      <form class="enterpriseLogin" action="php/enterpriseLogin.php" method="post">
        <div id="enterpriseH">
          <label for="enterpriseName">The name of your enterprise (between 5 and 30 characters and not be taken):</label>
          <input type="text" id="enterpriseName" name="enterpriseName" value="" onblur="checkAllEnterprise()">
          <label for="enterpriseDescription">Description of your enterprise (max 200 characters):</label>
          <input type="text" id="enterpriseDescription" name="enterpriseDescription" value="" onblur="checkAllEnterprise()">
          <label for="enterpriseEmail">Your email (must be valid and between 1 and 50 characters):</label>
          <input type="email" id="enterpriseEmail" name="enterpriseEmail" value="" onblur="checkAllEnterprise()">
          <label for="enterprisePhone">Your enterprise's phonenumber (numbers only and max 50 characters):</label>
          <input type="phonenumber" id="enterprisePhone" name="enterprisePhone" value="" onblur="checkAllEnterprise()">
          <label for="enterprisePassword">Password (must be between 5 and 50 characters):</label>
          <input id="enterprisePassword" type="text" name="enterprisePassword" value="" onblur="checkAllEnterprise()">
          <input id="loginButton" type="submit" name="" value="register/login" onmouseover="checkAllEnterprise()">
        </div>
      </form>
    </div>

    <?php include("php/footer.php") ?>
</div>
<script type="text/javascript" src="javascript/login.js"></script>
</body>
</html>
