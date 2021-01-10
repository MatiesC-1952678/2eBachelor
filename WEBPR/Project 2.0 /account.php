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
  <meta http-equiv="Content-Type" content="text/html"/>
  <meta name="description" content="A platform for enterprises and customers to easily meet">
  <meta name="keywords" content="Room,Country,enterprise,Book">
  <meta name="author" content="Maties Claesen">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
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
            echo "<p class='title'> USER: </p>";
            showUsers("SELECT * FROM users WHERE username = :search", $_SESSION["name"], "Room", "Room-Title", true, true);
          } else {
            echo "<p class='title'> ENTERPRISE: </p>";
            showUsers("SELECT * FROM enterprises WHERE name = :search", $_SESSION["name"], "Room", "Room-Title", false, true);
          }
          ?>
         <a href="php/logOut.php">Log out</a>
      </div>

      <!-- Uploaded Images -->
      <div class="userImages List">
        <?php 
        showImages($_SESSION["name"], $_SESSION["typeLogged"]);
        showVideos($_SESSION["name"], $_SESSION["typeLogged"]); 
        ?>
      </div>

      <!-- Upload Image Form -->
      <form class="boxed" id="UploadImageForm" action="uploads/uploadImage.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="name" value="<?php echo $_SESSION["name"]?>">
        <input type="hidden" name="type" value="<?php echo $_SESSION["typeLogged"]?>">
        <input type="hidden" name="url" value="../account.php">
        <label for="image">Select images that you want upload (you can add multiple): (jpg, jpeg, png)</label>
        <input id="image" type="file" name="imagesToUpload[]" accept="image/jpeg,image/jpg,image/png" multiple>
        <input type="submit" name="submit" value="Upload Image">
      </form>

      <!-- Upload Video Form -->
      <form class="boxed" id="UploadVideoForm" action="uploads/uploadVideo.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="name" value="<?php echo $_SESSION["name"]?>">
        <input type="hidden" name="type" value="<?php echo $_SESSION["typeLogged"]?>">
        <input type="hidden" name="url" value="../account.php">
        <label for="video">Select videos that you want upload (you can add multiple): (mv4, mp4)</label>
        <input id="video" type="file" name="videosToUpload[]" accept="video/mv4,video/mp4" multiple>
        <input type="submit" name="submit" value="Upload Video">
      </form>

      <?php include("php/footer.php"); ?>
    </div>
  </div>
</body>
</html>
