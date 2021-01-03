<?php
  session_start();
  require 'php/globals.php';
  require 'php/reusables.php';
  $isUser = isUser(); //only one php request required for this file
  function isUser() {
    $type = $_SESSION["typeLogged"];
    if ($type == "user") {
        return true;
    } else {
        return false;
    }
  }
  checkSession($_SESSION["typeLogged"], "", true, "login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Suite Dreams - Account</title>
  <meta charset="utf-8">
  <meta name="description" content="A platform for enterprises and customers to easily meet">
  <meta name="keywords" content="Room,Country,enterprise,Book">
  <meta name="author" content="Maties Claesen">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/account.css">
  <script type="text/javascript" src=""></script>
</head>

<body>
  <!-- Page Container -->
  <div id="PageContainer">

    <?php include("php/header.php"); ?>

    <!-- Main Content -->
    <div>
      <!-- AccountInfo -->
      <div class="boxed" id="AccountInfo">
        <?php
          if ($isUser) {
            echo "<h1> USER: </h1>";
            showUsers("SELECT * FROM users WHERE username = :search", $_SESSION["name"], "Room", "Room-Title", true, true);
          } else {
            echo "<h1> ENTERPRISE: </h1>";
            showUsers("SELECT * FROM enterprises WHERE name = :search", $_SESSION["name"], "Room", "Room-Title", false, true);
          }
          ?>
         <a href="php/logOut.php">Log out</a>
      </div>

      <!-- Uploaded Images -->
      <div class="userImages">
        <?php showImages($_SESSION["name"], $_SESSION["typeLogged"]); ?>
      </div>

      <!-- Upload Image Form -->
      <form class="boxed" id="UploadImageForm" action="uploads/uploadImage.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="name" value=<?php echo $_SESSION["name"]?>>
        <input type="hidden" name="type" value=<?php echo $_SESSION["typeLogged"]?>>
        <input type="hidden" name="url" value="../account.php">
        <label>Select an image that you want upload (you can add multiple in a row): (jpg, jpeg, png)</label>
        <input type="file" name="imageToUpload" accept="image/jpeg,image/jpg,image/png">
        <input type="submit" name="submit" value="Upload Image">
      </form>

    <?php include("php/footer.php"); ?>

  </div>
</div>
</body>
</html>
