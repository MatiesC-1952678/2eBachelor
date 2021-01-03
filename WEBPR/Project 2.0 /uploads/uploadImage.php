<?php
  session_start();
  //make one function that holds all this

  //TODO: add security for imagetypes, size, ...
  //GETTINGS NAMES
  require "../php/reusables.php";
  checkSession($_SESSION["typeLogged"], "", true, "../php/logOut.php");
  
  $name = $_POST["name"];
  $type = $_POST["type"];
  $url = $_POST["url"];
  $target_dir = "images/";
  $usersFileName = $_FILES["imageToUpload"]["tmp_name"];
  $imageType = strtolower(pathinfo($_FILES["imageToUpload"]["name"],PATHINFO_EXTENSION));
  echo "<p>$usersFileName + $imageType</p>";

  //CHECKS BEFOREHAND
  if($imageType != "jpg" && $imageType != "png" && $imageType != "jpeg") {
    echo '<p>png, jpg, jpeg files are only allowed.</p>
          <a href="'.$url.'"> go back </a>';
    die();
  }
  if ($_FILES["imageToUpload"]["size"] > 50000000) {
    echo '<p>your file is larger than 50000kb.</p>
          <a href="'.$url.'"> go back </a>';
    die();
  }

  //GENERATING IMAGE NAME
  $i = 0;
  while (file_exists($target_dir.$name."_".$type."_".$i.".jpg")) {
    $i = $i+1;
  }
  $newName = $name."_".$type."_".$i.".jpg";
  echo "<p>choses as i: $i </p><p> $newName </p>";

  //MAKING TARGET DIR
  $target_file=$target_dir.$newName;
  echo "<p>chosen as target file: $target_file</p>";
  if (isset($_POST["submit"])) {
    if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"],$target_file)) {
      echo "<p>file added to $target_file </p>";
    } else {
      echo "<p>file not added </p>";
      print_r($_FILES);
    }
  }

  $url = "../account.php";
  echo $url;
  //header("location: $url ");
 ?>
