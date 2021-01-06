<?php
    session_start();
    require "../php/globals.php";
    require "../php/reusables.php";
    $userone = $_SESSION["name"];
    $usertwo = $_GET["name"];
    $message = $_POST["message"];
    $time = date('Y-m-d H:i:s');
    checkSession($_SESSION["typeLogged"], "user", false, "../php/logOut.php", "You need to be logged in as a user to send messages");
    try {

        if (strlen($message) > 400)
            throw new Exception('message longer than 400 characters');

        echo $userone.$usertwo.$message.$time;
        $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
        $sth = $conn->prepare("INSERT INTO messages VALUES(:userone, :usertwo, :message, :time);");
        $sth->bindParam(':userone', $userone, PDO::PARAM_STR, strlen($userone));
        $sth->bindParam(':usertwo', $usertwo, PDO::PARAM_STR, strlen($usertwo));
        $sth->bindParam(':message', $message, PDO::PARAM_STR, strlen($message));
        $sth->bindParam(':time', $time, PDO::PARAM_STR, strlen($time));
        if ($sth->execute()) {
            echo "succesfully added message";
        }
        echo $usertwo;
        echo $userone;
        header("location: ../message.php?user=".urlencode($usertwo));

    } catch (PDOException $e) {
        print "Error! " . $e->getMessage() . "\n";
        die();
    } catch (Exception $e) {
        print "Error! " . $e->getMessage() . "\n";
        die();
    }

?>