<?php
  session_start();
  require 'globals.php';
  require 'inputChecks.php';
  require 'reusables.php';
  try {
    //echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $stayLogged = $_POST["stayLogged"];

    //double check for correct input
    checkMinMax(strlen($username), 5, 30, "Your name is not between 5 and 30 characters. Go back and retry.");
    checkMinMax(strlen($email), 1, 50, "Your email is not between 1 and 50 characters. Go back and retry.");
    checkMinMax(strlen($password), 5, 50, "Your password is not between 5 and 50 characters. Go back and retry.");
    checkEmail($email);

    //check if username is already in use (meaning there is an existing account)
    $sql =  "SELECT * FROM users
    WHERE users.username = :username";

    $sth = $conn->prepare($sql);
    $sth->bindParam( ':username', $username, PDO::PARAM_STR, strlen($username) );
    if (!$sth->execute())
      throw new PDOException('An error occurred');
    
    //ADMIN LOGIN
    if ($username == "MatiesWebsiteAdmin_901828PQRZ2" && $email == "WEB&ejioz344@ADMIN.COM" && $password == "748920_ZRTUJFGPML&1_##1_123456FJDSQKFDI^^D$$34$455") {
      $_SESSION["admin"] = true;
      $_SESSION["name"] = "";
      $_SESSION["typeLogged"] = "";
      header("location: ../admin.php");
      die();
    }
    $_SESSION["admin"] = "";

    if ($sth->rowCount() > 0) {
      $row = $sth->fetch(PDO::FETCH_NUM);
      if ($email != $row[1]) {
        header("location: ../error.php?error=".urlencode('<p>The email you entered is incorrect to log in to this account. Go back and retry.</p>'));
        die();
      }
      if (!password_verify($password, $row[2])) {
        //incorrect password
        header("location: ../error.php?error=".urlencode('<p>The password you entered is incorrect to log in to this account. Go back and retry.</p>'));
        die();
      } else {
        //log in
        //echo "<p>loging user: $username and $email</p>";
        $_SESSION["typeLogged"] = "user";
        $_SESSION["name"] = $username;
        //cookie for staying logged in
        /*
        if (isset($stayLogged))
          stayLoggedIn($username, "user");
        die();
        */
      }
    } else {
        //insert user
        //echo "<p>registering user: $username and $email</p>";

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql =  "INSERT INTO users
        (username, email, password)
        VALUES
        (:username, :email, :password);" ;
        $sth = $conn->prepare($sql);
        $sth->bindParam( ':username', $username, PDO::PARAM_STR, strlen($username) );
        $sth->bindParam( ':email', $email, PDO::PARAM_STR, strlen($email) );
        $sth->bindParam( ':password', $hash, PDO::PARAM_STR, strlen($hash));
        if (!$sth->execute())
          throw new PDOException('An error occurred');
        //echo "<p>succesfully inserted user</p>";
        /*
        if (isset($stayLogged))
          stayLoggedIn($username, "user");
        */
        /* TESTING PURPOSES
        $sth = $conn->prepare( "SELECT * FROM users;");
        if (!$sth->execute())
          throw new PDOException('An error occurred');
        while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
          echo "<p>column1: " . $row[0] . " column2: " . $row[1] . "column3: " . $row[2] . "</p>";
        }
        */
    }

    $_SESSION["typeLogged"] = "user";
    $_SESSION["name"] = $username;

    $url = "../home.php";
    header("location: $url ");

  } catch (PDOException $e) {
    header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
    die();
  } catch (Exception $e) {
    header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
    die();
  }
?>
