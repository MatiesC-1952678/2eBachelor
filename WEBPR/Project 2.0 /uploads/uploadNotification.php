<?php
    session_start();
    require '../php/globals.php';
    function notifyBookings($sql, $key1, $key2, $description) {
        try {
            $conn = new PDO("pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare($sql);
            $sth->bindParam( ':key1', $key1, PDO::PARAM_STR, strlen($key1));
            $sth->bindParam( ':key2', $key2, PDO::PARAM_STR, strlen($key2));
            if (!$sth->execute())
                echo "unsuccesfully queried bookings";
            while ($row = $sth->fetch(PDO::FETCH_NUM)) {
                uploadNotification($row[0], $description, date('Y-m-d'), date('H:i:s'), $row[1], $row[2]);
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die(); 
        }
    }

    function uploadNotification($name, $description, $date, $time, $room, $hotel) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("INSERT INTO notifications VALUES(:sentto, :description, :date, :time, :room, :hotel);");
            $sth->bindParam(':sentto', $name, PDO::PARAM_STR);
            $sth->bindParam(':description', $description, PDO::PARAM_STR);
            $sth->bindParam(':date', $date, PDO::PARAM_STR);
            $sth->bindParam(':time', $time, PDO::PARAM_STR);
            $sth->bindParam(':room', $room, PDO::PARAM_STR);
            $sth->bindParam(':hotel', $hotel, PDO::PARAM_STR);
            if ($sth->execute()) {
                echo "succesfully added notification";
            }
        } catch (PDOException $e) {
        print "Error! " . $e->getMessage() . "\n";
        die();
        } catch (Exception $e) {
        print "Error! " . $e->getMessage() . "\n";
        die();
        }
    }
?>