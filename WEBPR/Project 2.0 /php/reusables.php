<?php
    session_start();
    require 'globals.php';

    //universal because this can be used anywhere (not dependent on enterprise)
    function showRadioCountries() {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("SELECT * FROM countries");
            $sth->execute();
            echo '<p>All the available countries</p><ul>';
            while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
            echo '<label for="'.$row[0].'">'.$row[0].'</label>
                    <input type="radio" id="'.$row[0].'" name="hotelCountry" value="'.$row[0].'">';
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    //universal because this in multiple locations but needs an enterprise parameter
    function showRadioHotels($enterprise) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("SELECT * FROM hotels WHERE hotels.belongstoenterprise = :enterprise");
            $sth->bindParam(':enterprise', $enterprise, PDO::PARAM_STR, strlen($enterprise));
            $sth->execute();
            echo '<p>All the available hotels</p><ul>';
            while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
            echo '<label for="'.$row[1].'">'.$row[1].'</label>
                    <input type="radio" id="'.$row[1].'" name="hotelName" value="'.$row[1].'">';
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function likes($roomName, $hotelName) {
        try {
            if ($_SESSION["typeLogged"] == "user") {
                $user = $_SESSION["name"];
                $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
                $sth = $conn->prepare("SELECT * FROM likes WHERE likes.likedby = :name AND likes.room = :room AND likes.hotel = :hotel");
                $sth->bindParam(':name', $user, PDO::PARAM_STR, strlen($user));
                $sth->bindParam(':room', $roomName, PDO::PARAM_STR, strlen($roomName));
                $sth->bindParam(':hotel', $hotelName, PDO::PARAM_STR, strlen($hotelName));
                $sth->execute();
                $row = $sth->fetch(PDO::FETCH_NUM);
                if (empty($row))
                    echo '<a href="uploads/uploadLike.php?room='.urlencode($roomName).'&hotel='.urlencode($hotelName).'&status=uninterested">uninterested</a>';
                else 
                    echo '<a href="uploads/uploadLike.php?room='.urlencode($roomName).'&hotel='.urlencode($hotelName).'&status=interested">interested</a>';
            }
        }  catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function echoHotel($id, $titleId, $title, $enterprise, $description, $startDate, $endDate, $startTime, $endTime, $country, bool $editable = false) {
        echo '<article id="'.$id.'">
                <h1 id="'.$titleId.'">'.$title.'</h1><ul>
                <li> Enterprise: <a href="profile.php?name='.$enterprise.'&type=enterprise">'.$enterprise.'</a></li>
                <li> Description: '.$description.'</li>
                <li> Availability: '.$startDate.' - '.$endDate.' </li>
                <li> Opening hours: '.$startTime.' - '.$endTime.'</li> 
                <li> Country: '.$country.'</li>';
        if ($editable) {
            echo '<li><a href="edit.php?key1='.urlencode($enterprise).'&key2='.urlencode($title).'&type=hotel"> edit </a></li>
                <li><a href="uploads/delete.php?type=hotel&key1='.urlencode($enterprise).'&key2='.urlencode($title).'"> delete </a></li>';
        }
        echo    '</ul></article>';
    }

    //COULD ADD MORE DATA LIKE: start date, end date, time, country, ... -> alles van hotel
    function echoRoom($id, $titleId, $title, $enterprise, $hotel, $cost, $description, $start, $end, $max, bool $canBeBooked = false, bool $editable = false) {
        echo '<article id="'.$id.'">
                <h1 id="'.$titleId.'">'.$title.'</h1><ul>
                <li> Enterprise: <a href="profile.php?name='.$enterprise.'&type=enterprise">'.$enterprise.'</a></li>
                <li> Hotel: '.$hotel.'</li>
                <li> Cost: €'.$cost.'</li>';
        if (isset($description))
            echo '<li> Description: '.$description.'</li>';
        if (isset($start) && isset($end))
            echo '<li> Availability (overrides hotel):  '.$start.' - '.$end.'</li>';
        if (isset($max))
            echo '<li> Max Timeslot: '.$max.'</li>';
                if ($canBeBooked) {
                    echo '<li><a href="booking.php?roomName='.urlencode($title).'&hotelName='.urlencode($hotel).'">ReservationButton</a></li>';
                    likes($title, $hotel);
                }
        echo   '<li><a href="rating.php?room='.urlencode($title).'&hotel='.urlencode($hotel).'">Ratings</a></li>';
        if ($editable) {
            echo '<li><a href="edit.php?key1='.urlencode($enterprise).'&key2='.urlencode($hotel).'&key3='.urlencode($title).'&type=room"> edit </a></li>
                <li><a href="uploads/delete.php?type=room&key1='.urlencode($enterprise).'&key2='.urlencode($hotel).'&key3='.urlencode($title).'"> delete </a></li>';
        }
        echo    '</ul></article>';
    }

    function echoUser($id, $titleId, $name, $email, $password, bool $editable = false) {
        echo    '<article id="'.$id.'">
                    <h1 id="'.$titleId.'">'.$name.'</h1><ul>
                    <li><a href="profile.php?name='.urlencode($name).'&type=user">Go to profile</a></li>
                    <li><a href="message.php?user='.urlencode($name).'">Send a message</a></li>';
        if ($editable) {
            echo   '<li> Email: '.$email.'</li>
                    <li> Password: '.$password.'</li>
                    <li><a href="edit.php?key1='.urlencode($name).'&type=user"> edit </a></li>
                    <li><a href="uploads/delete.php?type=user&key1='.urlencode($name).'"> delete </a></li>';
        }
        echo      '</ul></article>';
    }

    function echoEnterprise($id, $titleId, $name, $description, $email, $phone, $password, bool $editable = false) {
        echo    '<article id="'.$id.'">
                    <h1 id="'.$titleId.'">'.$name.'</h1><ul>
                    <li> Description: '.$description.'</li>
                    <li> Email: '.$email.'</li>
                    <li> Phone: '.$phone.'</li>
                    <li><a href="profile.php?name='.urlencode($name).'&type=enterprise">Go to profile</a></li>';
        if ($editable) {
            echo   '<li> Password: '.$password.'</li>
                    <li><a href="edit.php?key1='.urlencode($name).'&type=enterprise"> edit </a></li>
                    <li><a href="uploads/delete.php?type=enterprise&key1='.urlencode($name).'"> delete </a></li>';
        }
        echo      '</ul></article>';
    }

    function echoNotification($id, $titleId, $description, $date, $time, $room, $hotel) {
        echo    '<article id="'.$id.'">
                    <h1 id="'.$titleId.'">'.$room.' - '.$date.'  '.$time.'</h1>
                    <p> Hotel: '.$hotel.'</p>
                    <p> Description: '.$description.' </p>
                    </article>';
    }

    function echoMessage($user, $message, $time) {
        if ($user == $_SESSION["name"]) {
            $mid = "RightMessage";
            $uid = "Right";
        } else  {
            $mid = "LeftMessage";
            $uid = "Left";
        }
        echo 
        '<p id="'.$uid.'">'.$user.' '.$time.'</p>
            <p id="'.$mid.'">'.$message.'</p>';
    }

    function echoRating($ratedby, $review, $rating) {
        echo    '<article id="RoomNonFloat">
                <h1 id="Room-Title">'.$ratedby.'</h1>
                <p> Review: '.$review.' </p>
                <p> Rating: '.$rating.' stars </p>
                </article>';
    }

    function echoBooking($bookedby, $startdate, $enddate) {
        echo    '<article id="Room">
                <h1 id="Room-Title">'.$bookedby.'</h1>
                <a href="profile.php?name='.urlencode($bookedby).'&type=user">Go to profile</a>
                <a href="message.php?user='.urlencode($bookedby).'">Send a message</a>
                <p> Unavailable: '.$startdate.' - '.$enddate.' </p>
                </article>';
    }

    function echoError($error = "An error has occurred") {
        echo "<p> $error </p>";
    }

    function showHotels($sql, $enterpriseName, $boxId, $titleId, bool $editable = false) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare($sql);
            $sth->bindParam(':enterprise', $enterpriseName, PDO::PARAM_STR, strlen($enterpriseName));
            $sth->execute();
            while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
                echoHotel($boxId, $titleId, $row[1], $row[0], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $editable);
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function showRooms($sql, $name, $boxId, $titleId, bool $canBeBooked = false, bool $isBooked = false, bool $editable = false, $hotel = "") {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare($sql);
            $sth->bindParam(':name', $name, PDO::PARAM_STR, strlen($name));
            $sth->bindParam(':hotel', $hotel, PDO::PARAM_STR, strlen($hotel));
            $sth->execute();
            while ($row = $sth->fetch( PDO::FETCH_ASSOC ) ) {
                echoRoom($boxId, $titleId, $row["name"], $row["belongstoenterprise"], $row["belongstohotel"], $row["cost"], $row["description"], $row["startdate"], $row["enddate"], $row["timeslotmax"], $canBeBooked, $editable);
                if ($isBooked)
                    echo '<p> period you are staying: '.$row["startd"].' - '.$row["endd"].'</p>
                          <a href="uploads/deleteBooking.php?room='.urlencode($row["name"]).'&hotel='.urlencode($row["belongstohotel"]).'"> cancel this booking </a>';
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function showUsers($sql, $search, $boxId, $titleId, bool $isUser = true, bool $editable = false) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare($sql);
            if (strpos($sql, "LIKE") > 0 )
                $search = '%'.strtolower($search).'%';
            $sth->bindParam(':search', $search, PDO::PARAM_STR, strlen($search));
            $sth->execute();
            while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
                if ($isUser)
                    echoUser($boxId, $titleId, $row[0], $row[1], $row[2], $editable);
                else {
                    echoEnterprise($boxId, $titleId, $row[0], $row[1], $row[2], $row[3], $row[4], $editable);
                }
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function showBookings($sql, $room, $hotel) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare($sql);
            $sth->bindParam(':room', $room, PDO::PARAM_STR, strlen($room));
            $sth->bindParam(':hotel', $hotel, PDO::PARAM_STR, strlen($hotel));
            $sth->execute();
            while ($row = $sth->fetch( PDO::FETCH_ASSOC ) ) {
                echoBooking($row["bookedby"], $row["startd"], $row["endd"]);
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    //TODO: CAN BE PUT TOGETHER WITH showHotels & showRooms
    function showSearch($sql, $search, bool $isRoom = true) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare($sql);
            if (strpos($sql, "LIKE") > 0 )
                $search = '%'.strtolower($search).'%';
            $sth->bindParam(':search', $search, PDO::PARAM_STR, strlen($search));
            $sth->execute();
            while ($row = $sth->fetch( PDO::FETCH_ASSOC ) ) {
                if ($isRoom)
                    echoRoom("Room", "Room-Title", $row["name"], $row["belongstoenterprise"], $row["belongstohotel"], $row["cost"], $row["description"], $row["startdate"], $row["enddate"], $row["timeslotmax"], true);
                else 
                    echoHotel("Room", "Room-Title", $row["name"], $row["belongstoenterprise"], $row["description"], $row["startdate"], $row["enddate"], $row["starttime"], $row["endtime"], $row["country"]);
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function showNotifications() {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("SELECT * FROM notifications WHERE sentto = :name");
            $sth->bindParam(':name', $_SESSION["name"], PDO::PARAM_STR, strlen($_SESSION["name"]));
            if (!$sth->execute())
                echo '<p> error getting notifications </p>';
            while ($row = $sth->fetch(PDO::FETCH_NUM)) {
                echoNotification("RoomNonFloat", "Room-Title", $row[1], $row[2], $row[3], $row[4], $row[5]);
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function showMessages($sql, $one, $two) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare($sql);
            $sth->bindParam(':userone', $one, PDO::PARAM_STR);
            $sth->bindParam(':useroneone', $one, PDO::PARAM_STR);
            $sth->bindParam(':usertwo', $two, PDO::PARAM_STR);
            $sth->bindParam(':usertwotwo', $two, PDO::PARAM_STR);
            if (!$sth->execute()) 
                echo 'error fetching messages';
            while ($row = $sth->fetch(PDO::FETCH_NUM)) {
                echoMessage($row[0], $row[2], $row[3]);
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function showDateSearch($sql, $date) {
        try {
            $conn = new PDO("pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare($sql);
            $sth->bindParam(':date', $date, PDO::PARAM_STR);
            if (!$sth->execute())
                echo '<p> error getting data </p>';
            while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                echoRoom("Room", "Room-Title", $row["name"], $row["belongstoenterprise"], $row["belongstohotel"], $row["cost"], $row["description"], $row["startdate"], $row["enddate"], $row["timeslotmax"], true);
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function showSingleRoomAndHotel($roomName, $hotelName) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("SELECT * FROM hotels,rooms WHERE rooms.belongstohotel = hotels.name AND rooms.name = :room AND hotels.name = :hotel");
            $sth->bindParam(':room', $roomName, PDO::PARAM_STR, strlen($roomName));
            $sth->bindParam(':hotel', $hotelName, PDO::PARAM_STR, strlen($hotelName));
            $sth->execute();
            $row = $sth->fetch( PDO::FETCH_NUM );
            echo '<p>Hotel:</p>';
            echoHotel("RoomNonFloat", "Room-Title", $row[1], $row[0], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);
            echo '<p>Room:</p>';
            echoRoom("RoomNonFloat", "Room-Title", $row[9], $row[0], $row[1], $row[11], $row[10], $row[12], $row[13], $row[14], false);
            
            $startDate = $row[12];
            $endDate = $row[13];
            if (!isset($startDate)) {
                $startDate = $row[3];
                $endDate = $row[4];
            }
            return $row[14]." ".$startDate." ".$endDate;
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function showRatings($room, $hotel) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("SELECT * FROM ratings WHERE ratings.room = :room  AND ratings.hotel = :hotel;");
            $sth->bindParam(':room', $room, PDO::PARAM_STR, strlen($room));
            $sth->bindParam(':hotel', $hotel, PDO::PARAM_STR, strlen($hotel));
            if (!$sth->execute())
                echo "unsuccesfully queried";
            while ($row = $sth->fetch( PDO::FETCH_NUM )) {
                echoRating($row[2], $row[3], $row[4]);
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function showImages($name, $type) {
          $i = 0;
          while(file_exists("uploads/images/".$name."_".$type."_".$i.".jpg")) {
            echo '<img class="uploadedImage" src="uploads/images/'.$name."_".$type."_".$i.'.jpg" alt="user uploaded image">';
            $i += 1;
          }
    }

    function pdo($sql, $key1 = "", $key2 = "", $key3 = "") {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare($sql);
            $sth->bindParam(':key1', $key1, PDO::PARAM_STR, strlen($key1));
            $sth->bindParam(':key2', $key2, PDO::PARAM_STR, strlen($key2));
            $sth->bindParam(':key3', $key3, PDO::PARAM_STR, strlen($key3));
            if (!$sth->execute())
                echo 'unsuccesfully fetched';
            $row = $sth->fetch( PDO::FETCH_NUM );
            return $row;
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }


    function checkSession($logged, $check, bool $type, $url = "php/logOut.php", $description = "Error! Session Expired") {
        //Session not expired and not ADMIN
        if ($_SESSION["admin"] != true) {
            if ($type) {
                if ($logged == $check) {
                    echo '<link rel="stylesheet" href="css/error.css">
                        <div class="ErrorPage">
                            <text>'.$description.'</text>
                            <a id="Nav-a" href="'.$url.'">
                                <text id="nav">Log back in</text>
                            </a>
                        </div>';
                    die();
                }
            } else {
                if ($logged != $check) {
                    echo '<link rel="stylesheet" href="css/error.css">
                        <div class="ErrorPage">
                            <text>'.$description.'</text>
                            <a id="Nav-a" href="'.$url.'">
                                <text id="nav">Log back in</text>
                            </a>
                        </div>';
                    die();
                }
            }
        }
    }
?>