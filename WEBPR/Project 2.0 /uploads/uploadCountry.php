<?php
  session_start();
  require "../php/globals.php";
  require "../php/reusables.php";
  checkSession($_SESSION["typeLogged"], "enterprise", false, "../php/logOut.php");
  try {
    echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    
    echo "<p>succesfully connected</p>";
    $countryName = $_POST["countryName"];
    $description = $_POST["countryDescription"];
    $cost = $_POST["cost"];

    echo "<p>checking parameters</p>";
    if (strlen($countryName) > 30 || strlen($description) > 200) {
        throw new Exception('parameters entered are too long');
    }

    echo "<p>parameters correct</p><p>adding country to database</p>";
    $sql = "INSERT INTO countries
    (title, description)
    VALUES
    (:title, :description);";
    $sth = $conn->prepare($sql);
    $sth->bindParam( ':title', $countryName, PDO::PARAM_STR, strlen($countryName));
    $sth->bindParam( ':description', $description, PDO::PARAM_STR, strlen($description));
    if (!$sth->execute())
      throw new PDOException('An error occurred');
    echo "<p>added country to database</p>";
    $url = "../management.php";
    header("location: $url ");

  } catch (PDOException $e) {
    print "Error! " . $e->getMessage() . "\n";
    die();
  } catch (Exception $e) {
    print "Error! " . $e->getMessage() . "\n";
    die();
  }
  
?>