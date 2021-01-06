<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">

    <title></title>
  </head>
  <body>
    <!-- Header -->
    <header>
      <!-- Logo -->
      <div class="LogoAll">
        <a href="home.php">
          <img src="resources/ChaseTheSunLogo(0.2).png" alt="The Chase The Sun Logo" width="150px" height="100px">
          <p class="LogoTitle">Suite Dreams</p>
          <link rel="stylesheet" href="css/header.css">
        </a>
        <!-- Navigation -->
        <nav class="HeaderNav">
          <ul class="Nav-ul">
            <li>
              <a class="Nav-a" href="accessibility.php">
                <img class="icon" src="resources/cog.svg" alt="accessibility" width="30px" height="30px">
                <text class="nav">Accessibility</text>
              </a>
            </li>
            <?php
                  if ($_SESSION["typeLogged"] == "user") {
                    echo '<li><a class="Nav-a" href="chat.php">
                      <img class="icon" src="resources/chat.svg" alt="Chat Messages" width="30px" height="30px">
                      <text class="nav">Chat Messages</text></a></li>';
                    echo '<li><a class="Nav-a" href="notifications.php">
                       <img class="icon" src="resources/plus.svg" alt="Notifications" width="30px" height="30px">
                       <text class="nav">Notifications</text></a></li>';
                  }
                  if ($_SESSION["typeLogged"] == "enterprise") {
                    echo '<li><a class="Nav-a" href="management.php">
                       <img class="icon" src="resources/plus.svg" alt="Management" width="30px" height="30px">
                       <text class="nav">Management</text>
                       </a>
                       </li>';
                  }
                if ($_SESSION["typeLogged"] == "user" || $_SESSION["typeLogged"] == "enterprise") {
                  echo '<li>
                    <a class="Nav-a" href="account.php">
                      <img class="icon" src="resources/user.svg" alt="Login" width="30px" height="30px">
                      <text class="nav">Account</text>
                    </a>
                  </li>';
                } else {
                  echo '<li>
                    <a class="Nav-a" href="login.php">
                      <img class="icon" src="resources/user.svg" alt="Login" width="30px" height="30px">
                      <text class="nav">Login</text>
                    </a>
                  </li>';
                }
             ?>
          </ul>
        </nav>
      </div>
    </header>
  <script type="text/javascript" src="javascript/header.js"></script>
  </body>
</html>
