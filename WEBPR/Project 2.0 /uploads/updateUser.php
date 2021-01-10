<?php
  session_start();
  require '../php/globals.php';
  require '../php/reusables.php';
  require '../error.php';
  checkSession($_SESSION["typeLogged"], "user", false, "../error.php");
  try {
    //echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    //echo "<p>succesfully connected</p>";
    $original = $_POST["original"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    //echo "<p> $original _ $username _ $email _ $password </p>";
    $sth = $conn->prepare("SELECT * FROM users WHERE users.username = :original");
    $sth->bindParam(':original', $original, PDO::PARAM_STR, strlen($original));
    if (!$sth->execute())
      throw new PDOException('An error occurred');
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    if (empty($username))
        $username = $row["username"];
    if (empty($email))
        $email = $row["email"];
    if (empty($password))
        $password = $row["password"];

    //echo "<p> $original _ $username _ $email _ $password </p>";
    //double check for correct input
    checkMinMax(strlen($username), 5, 30, "Your name is not between 5 and 30 characters. Go back and retry.");
    checkMinMax(strlen($email), 1, 50, "Your email is not between 1 and 50 characters. Go back and retry.");
    checkMinMax(strlen($password), 5, 50, "Your password is not between 5 and 50 characters. Go back and retry.");
    checkEmail($email);

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql =  "UPDATE users SET 
    username = :username, email = :email, password = :password
    WHERE username = :original";
    $sth = $conn->prepare($sql);
    $sth->bindParam( ':username', $username, PDO::PARAM_STR, strlen($username) );
    $sth->bindParam( ':email', $email, PDO::PARAM_STR, strlen($email) );
    $sth->bindParam( ':password', $hash, PDO::PARAM_STR, strlen($hash) );
    $sth->bindParam( ':original', $original, PDO::PARAM_STR, strlen($original) );
    if (!$sth->execute())
      throw new PDOException('An error occurred');

    if ($_SESSION["admin"] == true)
      $url = "../admin.php";
    else {
      $_SESSION["name"] = $username;
      $url = "../account.php";
    }
    header("location: $url ");

  } catch (PDOException $e) {
    header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
    die();
  } catch (Exception $e) {
    header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
    die();
  }
?>