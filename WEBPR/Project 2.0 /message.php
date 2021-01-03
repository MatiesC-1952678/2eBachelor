<?php
  session_start();
  require 'php/reusables.php';
  checkSession($_SESSION["typeLogged"], "user", false, "php/logOut.php", "You need to be logged in as a user to send messages");
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Chat Messages</title>
  <meta charset="utf-8">
  <meta name="description" content="A platform for hotels and customers to easily meet">
  <meta name="keywords" content="Room,Country,Hotel,Book">
  <meta name="author" content="Maties Claesen">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/message.css">
  <script type="text/javascript" src="javascript/chat.js"></script>

</head>

<body>
  <!-- Page Container -->
  <div id="PageContainer">

    <?php include("php/header.php") ?>

    <div id="ChatHead">
        <a class="element" href="chat.php"> Go Back </a>
        <p class="element">  <?php echo $_GET["user"] ?> </p>
        <a class="element" href="profile.php?name=<?php echo $_GET["user"] ?>&type=user"> Go To Profile </a>
    </div>
    <div class="MainContent" id="ChatMessages">
      <?php 
      showMessages("SELECT * FROM messages WHERE userone = :userone AND usertwo = :usertwo OR userone = :usertwotwo AND usertwo = :useroneone", $_SESSION["name"], $_GET["user"]); 
      ?>
    </div>

    <form id="ChatBox" action="uploads/uploadMessage.php?name=<?php echo urlencode($_GET["user"]); ?>" method="post">
        <input id="messagebox" type="text" placeholder="Aa" name="message">
        <div class ="element">
            <input id="submit" type="submit" name="submit" value="Send Message">
        </div>
    </form>

    <?php include("php/footer.php") ?>

  </div>
</body>
</html>