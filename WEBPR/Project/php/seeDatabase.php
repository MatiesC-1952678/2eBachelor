<?php
  require "globals.php";
  echo "<p>connecting to server</p>";
  try {
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "\n";
    die();
  }
  echo "<p>connected to server</p>";

  $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  $sql = "CREATE TABLE Users (
  username VARCHAR(30) NOT NULL,
  email VARCHAR(50) NOT NULL
  );" ;
  $conn->exec($sql);
  echo "<p>succesfully made table</p>";

  echo "<p> USERS: </p>";
  $sql = "SELECT * FROM Users;";
  $sth = $conn->prepare($sql);
  $sth->execute();
  while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
    echo "<p>username: " . $row[0] . " email: " . $row[1] . "</p>";
  }

  echo "<p> HOTELS: </p>";
  $sql = "SELECT * FROM Hotels;";
  $sth = $conn->prepare($sql);
  $sth->execute();
  while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
    echo "<p>id: " . $row[0] . " name: " . $row[1] . " description: " . $row[2] . " email: " . $row[3] . " phone: " . $row[4] . "</p>";
  }
  echo '<a href="http://localhost:8080/Project/home.html"> Click here to go back </a>';
?>
