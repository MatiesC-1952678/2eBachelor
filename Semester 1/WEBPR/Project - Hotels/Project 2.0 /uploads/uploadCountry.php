<?php
  session_start();
  require "../php/globals.php";
  require "../php/reusables.php";
  require "../php/inputChecks.php";
  checkSession($_SESSION["typeLogged"], "enterprise", false, "../error.php");
  try {
    //echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    
    //echo "<p>succesfully connected</p>";
    $countryName = $_POST["countryName"];
    $description = $_POST["countryDescription"];
    $cost = $_POST["cost"];

    //echo "<p>checking parameters</p>";
    checkMinMax(strlen($countryName), 5, 30, "Your name is not between 5 and 30 characters. Go back and retry.");
    checkMinMax(strlen($description), 0, 200, "Description is longer than 200 characters. Go back and retry.");

    //echo "<p>parameters correct</p><p>adding country to database</p>";
    $sql = "INSERT INTO countries
    (title, description)
    VALUES
    (:title, :description);";
    $sth = $conn->prepare($sql);
    $sth->bindParam( ':title', $countryName, PDO::PARAM_STR, strlen($countryName));
    $sth->bindParam( ':description', $description, PDO::PARAM_STR, strlen($description));
    if (!$sth->execute())
      throw new PDOException('An error occurred');
    //echo "<p>added country to database</p>";

    $url = "../management.php";
    header("location: $url ");

  } catch (PDOException $e) {
    header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
    die();
  } catch (Exception $e) {
    header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
    die();
  }
  
?>