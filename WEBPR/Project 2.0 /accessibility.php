<?php
  session_start();
  if (empty($_SESSION["typeLogged"])) {
    $_SESSION["typeLogged"] = "";
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Accessibility</title>
  <meta charset="utf-8">
  <meta name="description" content="A platform for hotels and customers to easily meet">
  <meta name="keywords" content="Room,Country,Hotel,Book">
  <meta name="author" content="Maties Claesen">
  <link rel="stylesheet" href="css/style.css">
  <script type="text/javascript" src=""></script>
</head>

<body>
  <!-- Page Container -->
  <div id="PageContainer">

    <?php include ("php/header.php") ?>

    <!-- Main Content -->
    <div>
      <!-- AccesibilityList -->
      <section id="AccesibilityList">
        <ul>
          <li>test</li>
          <li>test</li>
          <li>test</li>
        </ul>
      </section>

    <?php include("php/footer.php") ?>

  </div>
</div>
</body>
</html>
