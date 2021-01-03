<?php
  session_start();
  require "../php/globals.php";
  require "../php/reusables.php";
  checkSession($_SESSION["typeLogged"], "user", false, "../php/logOut.php", "You need to be logged in as a user to like things");
  try {
    echo "<p>connecting to server</p>";
    $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    
    echo "<p>succesfully connected</p>";
    $likedby = $_SESSION["name"];
    $room = urldecode($_GET["room"]);
    $hotel = urldecode($_GET["hotel"]);

    if ($_GET["status"] == "uninterested") {
        echo "<p>adding like to database</p>";
        $sql = "INSERT INTO likes
        (likedby, room, hotel)
        VALUES
        (:likedby, :room, :hotel);";
        $sth = $conn->prepare($sql);
        $sth->bindParam( ':likedby', $likedby, PDO::PARAM_STR, strlen($likedby));
        $sth->bindParam( ':room', $room, PDO::PARAM_STR, strlen($room));
        $sth->bindParam( ':hotel', $hotel, PDO::PARAM_STR, strlen($hotel));
        $sth->execute();
        echo "<p>added like to database</p>";
    } else {
        echo "<p>deleting like from database</p>";
        $sql = "DELETE FROM likes WHERE likedby = :likedby AND room = :room AND hotel = :hotel";
        $sth = $conn->prepare($sql);
        $sth->bindParam( ':likedby', $likedby, PDO::PARAM_STR, strlen($likedby));
        $sth->bindParam( ':room', $room, PDO::PARAM_STR, strlen($room));
        $sth->bindParam( ':hotel', $hotel, PDO::PARAM_STR, strlen($hotel));
        $sth->execute();
        echo "<p>deleted like from database</p>";
    }

    $url = "../notifications.php";
    header("location: $url ");

  } catch (PDOException $e) {
    print "Error! " . $e->getMessage() . "\n";
    die();
  } catch (Exception $e) {
    print "Error! " . $e->getMessage() . "\n";
    die();
  }
  
?>