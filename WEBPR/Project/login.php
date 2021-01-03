<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Login</title>
  <meta charset="utf-8">
  <meta name="description" content="A platform for hotels and customers to easily meet">
  <meta name="keywords" content="Room,Country,Hotel,Book">
  <meta name="author" content="Maties Claesen">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/login.css">
  <script type="text/javascript" src="javascript/login.js"></script>
</head>

<body>
<!-- Page Container -->
<div id="PageContainer">

  <!-- Header -->
  <header>
    <!-- Logo -->
    <div class="LogoAll">
      <a href="home.html">
        <img src="resources/ChaseTheSunLogo(0.2).png" alt="The Chase The Sun Logo">
      </a>
      <p class="LogoTitle">Suite Dreams</p>
      <!-- Navigation -->
      <nav class="HeaderNav">
        <ul id="Nav-ul">
          <li class="accessibility">
            <a id="Nav-a" href="accessibility.html">
              <img id="icon" src="resources/cog.svg" alt="accessibility">
              <text id="nav">Accessibility</text>
            </a>
          </li>
          <li class="addRoom">
            <a id="Nav-a" href="addRoom.html">
              <img id="icon" src="resources/plus.svg" alt="Add a room">
              <text id="nav">Add Room</text>
            </a>
          </li>
          <li class="notifications">
            <a id="Nav-a" href="notifications.html">
              <img id="icon" src="resources/invention.svg" alt="Notifications">
              <text id="nav">Notifications</text>
            </a>
          </li>
          <li class="login">
            <a id="Nav-a" href="login.php">
              <img id="icon" src="resources/user.svg" alt="Login">
              <text id="nav">Login</text>
            </a>
          </li>
          <li class="account">
            <a id="Nav-a" href="account.html">
              <img id="icon" src="resources/user.svg" alt="Login">
              <text id="nav">Account</text>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </header>

    <!-- Login -->
    <div class="loginPage">
      <form class="" action="php/seeDatabase.php" method="post">
        <input type="submit" name="" value="SEE DATABASE">
      </form>
      <form class="radioButtons" action="" method="post">
          <!--- user or hotel choice --->
          <p>Do you want to register as a User or as a Hotel?</p>
          <input type="radio" id="customer" name="typeOfUser" value="customer" onclick="showElements()">
          <label for="customer">Customer</label>
          <input type="radio" id="hotel" name="typeOfUser" value="hotel" onclick="showElements()">
          <label for="hotel">Hotel</label>
      </form>
        <!--- user login --->
      <form class="userLogin" action="php/userLogin.php" method="post">
        <div id="userH">
          <p>Your username (must be in between 5 and 30 characters long and must not be taken):</p>
          <label for="username">Username:</label>
          <input id="username" type="text" name="username" value="" onblur="checkUser()">
          <p>Your email (must be valid and less than 50 characters):</p>
          <label for="userEmail">E-mail:</label>
          <input id="userEmail" type="email" name="userEmail" value="" onblur="checkUser()">
          <input id="loginButton" type="submit" name="" value="register" onmouseover="checkUser()"> <br>
        </div>
      </form>
        <!--- hotel login --->
      <form class="hotelLogin" action="php/hotelLogin.php" method="post" enctype="multipart/form-data">
        <div id="hotelH">
          <p>Your profile picture (must be 200x200px max):</p>
          <label for="hotelProfilePic">Profile Picture:</label>
          <input type="file" id="HotelProfilePic" name="hotelProfilePic" accept="image/*">
          <label for="hotelName">The name of your hotel:</label>
          <input type="text" id="hotelName" name="hotelName" value="" onblur="checkName()">
          <label for="hotelDescription">Description of your hotel (max 200 characters):</label>
          <input type="text" id="hotelDescription" name="hotelDescription" value="" onblur="checkDescription()">
          <label for="hotelEmail">Your email (must be valid and less than 50 characters):</label>
          <input type="email" id="hotelEmail" name="hotelEmail" value="" onblur="checkEmail()">
          <label for="hotelPhone">Your hotel's phonenumber (numbers only):</label>
          <input type="phonenumber" id="hotelPhone" name="hotelPhone" value="" onblur="checkPhone()">
          <input id="loginButton" type="submit" name="" value="register">
          <!--- could make it so that the login button doesn't work when not all the fields are entered -> less stress on server --->
        </div>
      </form>
    </div>

    <!-- Footer -->
    <footer>
      <ul>
        <li>Copyrigth © 2020</li>
        <li><a href="#top">Back To Top</a></li>
      </ul>
    </footer>
</div>
</body>
</html>
