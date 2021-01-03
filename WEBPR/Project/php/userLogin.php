<?php
  session_start();
  require 'globals.php';
  try {
    echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);

    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    //NO UNIQUE IDENTIFIER
    /*
      $sql = "CREATE TABLE Users (
      username VARCHAR(30) NOT NULL,
      email VARCHAR(50) NOT NULL
    );" ;
    $conn->exec($sql);
    echo "<p>succesfully made table</p>";
    */

    $username = $_POST["username"];
    $email = $_POST["userEmail"];

    echo "<p>$username and $email</p>";

    $sql =  "INSERT INTO users
    (username, email)
    VALUES
    (:username, :email);" ;
    $sth = $conn->prepare($sql);
    $sth->bindParam( ':username', $username, PDO::PARAM_STR, strlen($username) );
    $sth->bindParam( ':email', $email, PDO::PARAM_STR, strlen($email) );
    $sth->execute();
    echo "<p>succesfully inserted user</p>";

    $sth = $conn->prepare( "SELECT * FROM users;");
    $sth->execute();
    while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
      echo "<p>column1: " . $row[0] . " column2: " . $row[1] . "</p>";
    }

    $_SESSION["typeLogged"] = "user";

    $url = "../home.php";
    header("location: $url ");

  } catch (PDOException $e) {
    print "Error! " . $e->getMessage() . "\n";
    die();
  }
?>
