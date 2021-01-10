<?php
  session_start();
  require '../php/globals.php';
  require '../php/reusables.php';
  checkSession($_SESSION["typeLogged"], "user", false, "../php/logOut.php");
  try {
    echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    echo "<p>succesfully connected</p>";
    $original = $_POST["original"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    echo "<p> $original _ $username _ $email _ $password </p>";

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

    echo "<p> $original _ $username _ $email _ $password </p>";

    //double check for correct input
    if (strlen($username) < 5 || strlen($username) > 30) {
      throw new Exception("name is not between 5 and 30 char", 1);
    }
    if (strlen($email) > 50) {
      throw new Exception('email is over 50', 1);
    }
    if (strlen($password) < 5 || strlen($password) > 50) {
      throw new Exception("password is not correct", 1);
    }

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
    print "Error! " . $e->getMessage() . "\n";
    echo '<p>go back!</p>';
    die();
  } catch (Exception $e) {
    print "Error! " . $e->getMessage() . "\n";
    echo '<p>go back!</p>';
    die();
  }
?>