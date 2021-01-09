<?php session_start(); ?>

<!-- Header -->
<header>
  <!-- Logo -->
  <div class="LogoAll sticky">
    <a href="home.php">
      <img class="Logo" src="resources/ChaseTheSunLogo(0.2).png" alt="The Chase The Sun Logo" width="130" height="130">
      <p class="LogoTitle">Suite Dreams</p>
      <link rel="stylesheet" href="css/header.css">
    </a>
    <!-- Navigation -->
    <nav class="HeaderNav">
      <ul class="Nav-ul">
        <li>
          <a class="Nav-a" href="accessibility.php">
            <img class="icon" src="resources/cog.svg" alt="accessibility" width="30" height="30">
            <p class="nav">Accessibility</p>
          </a>
        </li>
        <?php
              if ($_SESSION["typeLogged"] == "user") {
                echo '<li><a class="Nav-a" href="chat.php">
                  <img class="icon" src="resources/chat.svg" alt="Chat Messages" width="30" height="30">
                  <p class="nav">Chat Messages</p></a></li>';
                echo '<li><a class="Nav-a" href="notifications.php">
                    <img class="icon" src="resources/plus.svg" alt="Notifications" width="30" height="30">
                    <p class="nav">Notifications</p></a></li>';
              }
              if ($_SESSION["typeLogged"] == "enterprise") {
                echo '<li><a class="Nav-a" href="management.php">
                    <img class="icon" src="resources/plus.svg" alt="Management" width="30" height="30">
                    <p class="nav">Management</p></a></li>';
              }
            if ($_SESSION["typeLogged"] == "user" || $_SESSION["typeLogged"] == "enterprise") {
              echo '<li>
                <a class="Nav-a" href="account.php">
                  <img class="icon" src="resources/user.svg" alt="Login" width="30" height="30">
                  <p class="nav">Account</p>
                </a>
              </li>';
            } else {
              echo '<li>
                <a class="Nav-a" href="login.php">
                  <img class="icon" src="resources/user.svg" alt="Login" width="30" height="30">
                  <p class="nav">Login</p>
                </a>
              </li>';
            }
          ?>
      </ul>
    </nav>
  </div>
</header>
<script src="javascript/header.js"></script>

