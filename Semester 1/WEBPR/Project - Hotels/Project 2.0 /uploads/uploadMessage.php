<?php
    session_start();
    require "../php/globals.php";
    require "../php/reusables.php";
    require "../php/inputChecks.php";
    $userone = $_SESSION["name"];
    $usertwo = $_POST["name"];
    $message = $_POST["message"];
    $time = date('Y-m-d H:i:s');
    checkSession($_SESSION["typeLogged"], "user", false, "../error.php", "You need to be logged in as a user to send messages. Go log in as a user.");
    try {
        checkMinMax(strlen($message), 1, 400, "Your message is longer than 400 characters. Go back and retry.");
        //echo $userone.$usertwo.$message.$time;
        $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
        $sth = $conn->prepare("INSERT INTO messages VALUES(:userone, :usertwo, :message, :time);");
        $sth->bindParam(':userone', $userone, PDO::PARAM_STR, strlen($userone));
        $sth->bindParam(':usertwo', $usertwo, PDO::PARAM_STR, strlen($usertwo));
        $sth->bindParam(':message', $message, PDO::PARAM_STR, strlen($message));
        $sth->bindParam(':time', $time, PDO::PARAM_STR, strlen($time));
        if (!$sth->execute()) {
            throw new Exception('Error');
        }
        //echo $usertwo;
        //echo $userone;
        header("location: ../message.php?user=".urlencode($usertwo));

    } catch (PDOException $e) {
        header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
        die();
    } catch (Exception $e) {
        header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
        die();
    }

?>