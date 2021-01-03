<?php
    session_start();
    require "../php/globals.php";
    require "../php/reusables.php";
    $user = $_POST["user"];
    $room = $_POST["room"];
    $hotel = $_POST["hotel"];
    $review = $_POST["review"];
    $rating = $_POST["rating"];

    checkSession($_SESSION["typeLogged"], "user", false, "../php/logOut.php", "You need to be logged in as a user to upload ratings");

    try {
        if (strlen($review) > 200) 
            throw new Exception('review longer than 200 characters');
        if ($rating > 5 || $rating < 0)
            throw new Exception('rating is not in range');
        echo $user . $room . $hotel . $review . $rating;
        $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
        $sth = $conn->prepare("INSERT INTO ratings VALUES(:room, :hotel, :user, :review, :rating);");
        $sth->bindParam(':room', $room, PDO::PARAM_STR, strlen($room));
        $sth->bindParam(':hotel', $hotel, PDO::PARAM_STR, strlen($hotel));
        $sth->bindParam(':user', $user, PDO::PARAM_STR, strlen($user));
        $sth->bindParam(':review', $review, PDO::PARAM_STR, strlen($review));
        $sth->bindParam(':rating', $rating, PDO::PARAM_STR, strlen($rating));
        if ($sth->execute()) {
            echo "succesfully added message";
        }
        header("location: ../rating.php?room=".urlencode($room)."&hotel=".urlencode($hotel));

    } catch (PDOException $e) {
        print "Error! " . $e->getMessage() . "\n";
        die();
    } catch (Exception $e) {
        print "Error! " . $e->getMessage() . "\n";
        die();
    }

?>