<?php
  session_start();
  $_SESSION["typeLogged"] = "";
  session_destroy();
  $url = "../home.php";
  header("location: $url ");
?>
