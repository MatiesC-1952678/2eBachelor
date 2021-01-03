<?php
  session_start();
  $_SESSION["typeLogged"] = "";
  $_SESSION["name"] = "";
  session_destroy();
  $url = "../login.php";
  header("location: $url ");
?>
