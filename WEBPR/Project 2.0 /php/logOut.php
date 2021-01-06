<?php
  session_start();
  $_SESSION["typeLogged"] = "";
  $_SESSION["name"] = "";
  //setcookie("loggedIn", "", time()-3600);
  session_destroy();
  $url = "../login.php";
  header("location: $url ");
?>
