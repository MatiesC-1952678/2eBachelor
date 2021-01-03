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
          <img src="resources/ChaseTheSunLogo(0.2).png" alt="The Chase The Sun Logo">
          <p class="LogoTitle">Suite Dreams</p>
        </a>
        <!-- Navigation -->
        <nav class="HeaderNav">
          <ul id="Nav-ul">
            <li>
              <a id="Nav-a" href="accessibility.php">
                <img id="icon" src="resources/cog.svg" alt="accessibility">
                <text id="nav">Accessibility</text>
              </a>
            </li>
            <?php
                  if ($_SESSION["typeLogged"] == "user") {
                    echo '<li><a id="Nav-a" href="chat.php">
                      <img id="icon" src="resources/chat.svg" alt="Chat Messages">
                      <text id="nav">Chat Messages</text></a></li>';
                    echo '<li><a id="Nav-a" href="notifications.php">
                       <img id="icon" src="resources/plus.svg" alt="Notifications">
                       <text id="nav">Notifications</text></a></li>';
                  }
                  if ($_SESSION["typeLogged"] == "enterprise") {
                    echo '<li><a id="Nav-a" href="management.php">
                       <img id="icon" src="resources/plus.svg" alt="Management">
                       <text id="nav">Management</text></a></li>';
                  }
                if ($_SESSION["typeLogged"] == "user" || $_SESSION["typeLogged"] == "enterprise") {
                  echo '<li>
                    <a id="Nav-a" href="account.php">
                      <img id="icon" src="resources/user.svg" alt="Login">
                      <text id="nav">Account</text>
                    </a>
                  </li>';
                } else {
                  echo '<li>
                    <a id="Nav-a" href="login.php">
                      <img id="icon" src="resources/user.svg" alt="Login">
                      <text id="nav">Login</text>
                    </a>
                  </li>';
                }
             ?>
          </ul>
        </nav>
      </div>
    </header>
  </body>
</html>
