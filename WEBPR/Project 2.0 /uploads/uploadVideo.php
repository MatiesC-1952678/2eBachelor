<?php
  session_start();
  require "../php/reusables.php";
  checkSession($_SESSION["typeLogged"], "", true, "../php/logOut.php");
  
  //echo count($_FILES["imagesToUpload"]["name"]);
  $name = $_POST["name"];
  $type = $_POST["type"];
  for ($i = 0; $i < count($_FILES["videosToUpload"]["name"]); $i++) {
    uploadOneVideo($_FILES["videosToUpload"]["tmp_name"][$i], $_FILES["videosToUpload"]["name"][$i], $_FILES["videosToUpload"]["size"][$i], $name, $type);
  }

  $url = $_POST["url"];
  header("location: $url ");
 ?>
