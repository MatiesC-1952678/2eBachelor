<?php
  session_start();
  require 'globals.php';
  require 'inputChecks.php';
  try {
    echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    //double check for correct input
    checkMinMax(strlen($username), 5, 30, "Name is not between 5 and 30 characters");
    checkMinMax(strlen($email), 1, 50, "Email is over 50 characters");
    checkMinMax(strlen($password), 5, 50, "Password is not between 5 and 50 characters");
    checkEmail($email);

    //check if username is already in use (meaning there is an existing account)
    $sql =  "SELECT * FROM users
    WHERE users.username = :username";

    $sth = $conn->prepare($sql);
    $sth->bindParam( ':username', $username, PDO::PARAM_STR, strlen($username) );
    $sth->execute();
    $row = $sth->fetch(PDO::FETCH_NUM);
    
    //ADMIN LOGIN
    if ($username == "MatiesWebsiteAdmin_901828PQRZ2_#2" && $password == "748920_ZRTUJFGPML&1") {
      $_SESSION["admin"] = true;
      header("location: ../admin.php");
    }

    if ($sth->rowCount() > 0) {
      if ($email != $row[1]) {
        echo "<p>email incorrect to log in to the account $username</p>";
        die();
      }
      if ($password != $row[2]) {
        //incorrect password
        echo "<p>password incorrect</p>";
      } else {
        //log in
        echo "<p>loging user: $username and $email</p>";
        $_SESSION["typeLogged"] = "user";
        $_SESSION["name"] = $username;
      }
    } else {
        //insert user
        echo "<p>registering user: $username and $email</p>";

        $sql =  "INSERT INTO users
        (username, email, password)
        VALUES
        (:username, :email, :password);" ;
        $sth = $conn->prepare($sql);
        $sth->bindParam( ':username', $username, PDO::PARAM_STR, strlen($username) );
        $sth->bindParam( ':email', $email, PDO::PARAM_STR, strlen($email) );
        $sth->bindParam( ':password', $password, PDO::PARAM_STR, strlen($password));
        $sth->execute();
        echo "<p>succesfully inserted user</p>";

        $sth = $conn->prepare( "SELECT * FROM users;");
        $sth->execute();
        while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
          echo "<p>column1: " . $row[0] . " column2: " . $row[1] . "column3: " . $row[2] . "</p>";
        }
    }

    $_SESSION["typeLogged"] = "user";
    $_SESSION["name"] = $username;

    $url = "../home.php";
    header("location: $url ");

  } catch (PDOException $e) {
    print "Error! " . $e->getMessage() . "\n";
    echo '<p><a href="../login.php"> go back </a></p>';
    die();
  } catch (Exception $e) {
    print "Error! " . $e->getMessage() . "\n";
    echo '<p><a href="../login.php"> go back </a></p>';
    die();
  }
?>
