<?php
  session_start();
  if (empty($_SESSION["typeLogged"])) {
    $_SESSION["typeLogged"] = "";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Home</title>
  <meta charset="utf-8">
  <meta name="description" content="A platform for hotels and customers to easily meet">
  <meta name="keywords" content="Room,Country,Hotel,Book">
  <meta name="author" content="Maties Claesen">
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript" src=""></script>

</head>

<!-- Kermis == Room, Gemeente == Hotel, Zone == Country -->

<body>
  <!-- Page Container -->
  <div id="PageContainer">
    <!-- Header -->
    <header>
      <!-- Logo -->
      <div class="LogoAll">
        <a href="home.php">
          <img src="resources/ChaseTheSunLogo(0.2).png" alt="The Chase The Sun Logo">
        </a>
        <p class="LogoTitle">Suite Dreams</p>
        <!-- Navigation -->
        <nav class="HeaderNav">
          <ul id="Nav-ul">
            <li>
              <a id="Nav-a" href="accessibility.html">
                <img id="icon" src="resources/cog.svg" alt="accessibility">
                <text id="nav">Accessibility</text>
              </a>
            </li>
            <?php
                  if ($_SESSION["typeLogged"] == "user") {
                    echo '<li><a id="Nav-a" href="notifications.html">
                       <img id="icon" src="resources/plus.svg" alt="Add a room">
                       <text id="nav">My List</text></a></li>';
                  } else { if ($_SESSION["typeLogged"] == "hotel") {
                    echo '<li><a id="Nav-a" href="addRoom.html">
                       <img id="icon" src="resources/plus.svg" alt="Add a room">
                       <text id="nav">My List</text></a></li>';
                  } else {
                    echo '';
                  }
                  }
            ?>
            <?php
                if ($_SESSION["typeLogged"] == "user" || $_SESSION["typeLogged"] == "hotel") {
                  echo '<li>
                    <a id="Nav-a" href="account.html">
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

    <!-- Main Content -->
    <div class="MainContent">
      <!-- Searchbar -->
      <section id="Searchbar">
          <input type="text" placeholder="   Search..">
          <!-- <img id="SearchIcon" src="resources/plus.svg" alt="plus placeholder">
          <img id="SearchIcon" src="resources/invention.svg" alt="invention placeholder"> --->
      </section>

      <!-- RoomList -->
      <div id="RoomList">
        <!-- Some examples of the items you could see in this list -->
        <article id="Room">
          <h1 id="Room-Title">Room in Greece</h1>
          <ul>
            <li>Name</li>
            <li>Country</li>
            <li>Hotel</li>
            <li><a href="booking.html">ReservationButton</a></li>
            <li>...</li>
          </ul>
        </article>
        <article id="Room">
          <h1 id="Room-Title">Room in Greece</h1>
          <ul>
            <li>Name</li>
            <li>Country</li>
            <li>Hotel</li>
            <li><a href="booking.html">ReservationButton</a></li>
            <li>...</li>
          </ul>
        </article>
        <article id="Room">
          <h1 id="Room-Title">Room in Greece</h1>
          <ul>
            <li>Name</li>
            <li>Country</li>
            <li>Hotel</li>
            <li><a href="booking.html">ReservationButton</a></li>
            <li>...</li>
          </ul>
        </article>
        <article id="Room">
          <h1 id="Room-Title">Room in Greece</h1>
          <ul>
            <li>Name</li>
            <li>Country</li>
            <li>Hotel</li>
            <li><a href="booking.html">ReservationButton</a></li>
            <li>...</li>
          </ul>
        </article>
        <article id="Room">
          <h1 id="Room-Title">Room in Greece</h1>
          <ul>
            <li>Name</li>
            <li>Country</li>
            <li>Hotel</li>
            <li><a href="booking.html">ReservationButton</a></li>
            <li>...</li>
          </ul>
        </article>
        <article id="Room">
          <h1 id="Room-Title">Room in Greece</h1>
          <ul>
            <li>Name</li>
            <li>Country</li>
            <li>Hotel</li>
            <li><a href="booking.html">ReservationButton</a></li>
            <li>...</li>
          </ul>
        </article>
        <article id="Room">
          <h1 id="Room-Title">Room in Greece</h1>
          <ul>
            <li>Name</li>
            <li>Country</li>
            <li>Hotel</li>
            <li><a href="booking.html">ReservationButton</a></li>
            <li>...</li>
          </ul>
        </article>

      </div>
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
