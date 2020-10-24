<?php
  require "globals.php";
  try {
    $conn = new PDO( "mysql:dbname=$db_name;host=$db_host", $db_user, $db_password );
    $sql =  'CREATE TABLE Users (
              username VARCHAR(30) NOT NULL,
              email VARCHAR(50) NOT NULL
            );';
    $sth = $conn->prepare( $sql );
    $sth->execute();
    
  }
?>
