<?php
    session_start();
    require "../php/globals.php";
    require "../php/reusables.php";
    require "../php/inputChecks.php";
    $user = $_POST["user"];
    $room = $_POST["room"];
    $hotel = $_POST["hotel"];
    $review = $_POST["review"];
    $rating = $_POST["rating"];

    checkSession($_SESSION["typeLogged"], "user", false, "../error.php", "You need to be logged in as a user to upload ratings");

    try {
        checkMinMax(strlen($review), 0, 200, "<p>Your review is longer than 200 characters. Go back and retry.</p>");
        checkMinMax($rating, 0, 5, "<p>Your rating is not between 0 and 5 stars. Go back and retry.</p>");
        //echo $user . $room . $hotel . $review . $rating;
        $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
        $sth = $conn->prepare("INSERT INTO ratings VALUES(:room, :hotel, :user, :review, :rating);");
        $sth->bindParam(':room', $room, PDO::PARAM_STR, strlen($room));
        $sth->bindParam(':hotel', $hotel, PDO::PARAM_STR, strlen($hotel));
        $sth->bindParam(':user', $user, PDO::PARAM_STR, strlen($user));
        $sth->bindParam(':review', $review, PDO::PARAM_STR, strlen($review));
        $sth->bindParam(':rating', $rating, PDO::PARAM_STR, strlen($rating));
        if (!$sth->execute()) 
            throw new Exception();
        header("location: ../rating.php?room=".urlencode($room)."&hotel=".urlencode($hotel));

    } catch (PDOException $e) {
        header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
        die();
    } catch (Exception $e) {
        header("location: ../error.php?error=".urlencode('<p>An error occurred. Go back and retry.</p>'));
        die();
    }

?>