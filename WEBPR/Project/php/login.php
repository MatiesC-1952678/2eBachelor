<?php
  require "globals.php";
  try {
    echo "test";
    $conn = new PDO( "mysql:dbname=" . $DB_NAME . ";host=" . $DB_HOST", $DB_USER, $DB_PASSWORD );
    $sql =  'CREATE TABLE Users (
              username VARCHAR(30) NOT NULL,
              email VARCHAR(50) NOT NULL
            );';
    $sth = $conn->prepare( $sql );
    $sth->execute();

  }
?>
