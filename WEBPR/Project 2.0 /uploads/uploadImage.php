<?php
  session_start();
  require "../php/reusables.php";
  checkSession($_SESSION["typeLogged"], "", true, "../php/logOut.php");
  
  //echo count($_FILES["imagesToUpload"]["name"]);
  $name = $_POST["name"];
  $type = $_POST["type"];
  for ($i = 0; $i < count($_FILES["imagesToUpload"]["name"]); $i++) {
    uploadOneImage($_FILES["imagesToUpload"]["tmp_name"][$i], $_FILES["imagesToUpload"]["name"][$i], $_FILES["imagesToUpload"]["size"], $name, $type);
  }

  $url = $_POST["url"];
  header("location: $url ");
 ?>
