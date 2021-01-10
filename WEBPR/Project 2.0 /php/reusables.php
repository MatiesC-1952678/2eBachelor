<?php
    session_start();
    require 'globals.php';

    //universal because this can be used anywhere (not dependent on enterprise)
    function showRadioCountries(bool $nonEdit = true) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("SELECT * FROM countries");
            if (!$sth->execute())
                throw new PDOException('An error occurred');
            echo '<p>All the available countries*</p>';
            if ($nonEdit)
                $func = "checkAllHotel()";
            else
                $func = "checkEditHotel()";
            while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
            echo '<label for="'.urlencode($row[0]).'">'.htmlspecialchars($row[0]).'</label class="radioElements">
                    <input type="radio" class="radioCountry" id="'.urlencode($row[0]).'" name="hotelCountry" value="'.htmlspecialchars($row[0]).'" onclick="'.$func.'" class="radioElements">';
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    //universal because this in multiple locations but needs an enterprise parameter
    function showRadioHotels($enterprise, bool $nonEdit = true) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("SELECT * FROM hotels WHERE hotels.belongstoenterprise = :enterprise");
            $sth->bindParam(':enterprise', $enterprise, PDO::PARAM_STR, strlen($enterprise));
            if (!$sth->execute())
                throw new PDOException('An error occurred');
            if ($nonEdit)
                $func = "checkAllRoom()";
            else
                $func = "checkEditRoom()";
            echo '<p>All the available hotels*</p>';
            while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
            echo '<label for="'.urlencode($row[1]).'">'.htmlspecialchars($row[1]).'</label>
                    <input type="radio" class="radioHotel" id="'.urlencode($row[1]).'" name="hotelName" value="'.htmlspecialchars($row[1]).'" onclick="'.$func.'">';
            }
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function likes($roomName, $hotelName, $isUl = true) {
        try {
            if ($_SESSION["typeLogged"] == "user") {
                $user = $_SESSION["name"];
                $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
                $sth = $conn->prepare("SELECT * FROM likes WHERE likes.likedby = :name AND likes.room = :room AND likes.hotel = :hotel");
                $sth->bindParam(':name', $user, PDO::PARAM_STR, strlen($user));
                $sth->bindParam(':room', $roomName, PDO::PARAM_STR, strlen($roomName));
                $sth->bindParam(':hotel', $hotelName, PDO::PARAM_STR, strlen($hotelName));
                if (!$sth->execute())
                    throw new PDOException('An error occurred');
                $row = $sth->fetch(PDO::FETCH_NUM);
                if ($isUl)
                    echo '<li>';
                if (empty($row))
                    echo '<a href="uploads/uploadLike.php?room='.urlencode($roomName).'&hotel='.urlencode($hotelName).'&status=uninterested">uninterested</a>';
                else 
                    echo '<a href="uploads/uploadLike.php?room='.urlencode($roomName).'&hotel='.urlencode($hotelName).'&status=interested">interested</a>';
                if ($isUl)
                    echo '</li>';
            }
        }  catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function echoHotel($class, $titleClass, $title, $enterprise, $description, $startDate, $endDate, $startTime, $endTime, $country, bool $editable = false) {
        echo '<article class="'.$class.'">
                <h2 class="'.$titleClass.' title">'.htmlspecialchars($title).'</h2><ul>
                <li> Enterprise: <a href="profile.php?name='.urlencode($enterprise).'&type=enterprise">'.htmlspecialchars($enterprise).'</a></li>
                <li> Description: '.htmlspecialchars($description).'</li>
                <li> Availability: '.$startDate.' - '.$endDate.' </li>
                <li> Opening hours: '.$startTime.' - '.$endTime.'</li> 
                <li> Country: '.htmlspecialchars($country).'</li>';
        if ($editable) {
            echo '<li><a href="edit.php?key1='.urlencode($enterprise).'&key2='.urlencode($title).'&type=hotel"> edit </a></li>
                <li><a href="uploads/delete.php?type=hotel&key1='.urlencode($enterprise).'&key2='.urlencode($title).'"> delete </a></li>';
        }
        echo    '</ul>';
        showImages($title, "hotel");
        showVideos($title, "hotel");
        echo    '</article>';
    }

    //COULD ADD MORE DATA LIKE: start date, end date, time, country, ... -> alles van hotel
    function echoRoom($class, $titleClass, $title, $enterprise, $hotel, $cost, $description, $start, $end, $max, $long = 0, $lat = 0, bool $canBeBooked = false, bool $editable = false) {
        echo '<article class="'.$class.'">
                <h2 class="'.$titleClass.' title">'.htmlspecialchars($title).'</h2><ul>
                <li> Enterprise: <a href="profile.php?name='.urlencode($enterprise).'&type=enterprise">'.htmlspecialchars($enterprise).'</a></li>
                <li> Hotel: '.htmlspecialchars($hotel).'</li>
                <li> Cost: €'.$cost.'</li>';
        if (!empty($description))
            echo '<li> Description: '.htmlspecialchars($description).'</li>';
        if (!empty($start) && !empty($end))
            echo '<li> Availability:  '.$start.' - '.$end.' (overrides hotel) </li>';
        if (!empty($max))
            echo '<li> Max Timeslot: '.$max.'</li>';
                if ($canBeBooked) {
                    echo '<li><a href="booking.php?roomName='.urlencode($title).'&hotelName='.urlencode($hotel).'">Book This Room</a></li>';
                    likes($title, $hotel);
                }
        echo   '<li><a href="rating.php?room='.urlencode($title).'&hotel='.urlencode($hotel).'">Ratings</a></li>';
        if ($editable) {
            echo '<li><a href="edit.php?key1='.urlencode($enterprise).'&key2='.urlencode($hotel).'&key3='.urlencode($title).'&type=room"> edit </a></li>
                <li><a href="uploads/delete.php?type=room&key1='.urlencode($enterprise).'&key2='.urlencode($hotel).'&key3='.urlencode($title).'"> delete </a></li>';
        }
        if ($long != 0 && $lat != 0)
            echo    '<li> Coordinates (long,lat): '.$long.', '.$lat.'</li>';
        echo    '</ul>';
        showImages($title, "room");
        showVideos($title, "room");
        echo    '</article>';
    }

    function echoUser($class, $titleClass, $name, $email, bool $editable = false) {
        echo    '<article class="'.$class.'">
                    <h2 class="'.$titleClass.' title">'.htmlspecialchars($name).'</h2><ul>
                    <li><a href="profile.php?name='.urlencode($name).'&type=user">Go to profile</a></li>
                    <li><a href="message.php?user='.urlencode($name).'">Send a message</a></li>';
        if ($editable) {
            echo   '<li> Email: '.htmlspecialchars($email).'</li>
                    <li><a href="edit.php?key1='.urlencode($name).'&type=user"> edit </a></li>
                    <li><a href="uploads/delete.php?type=user&key1='.urlencode($name).'"> delete </a></li>';
        }
        echo      '</ul></article>';
    }

    function echoEnterprise($class, $titleClass, $name, $description, $email, $phone, bool $editable = false) {
        echo    '<article class="'.$class.'">
                    <h2 class="'.$titleClass.' title">'.htmlspecialchars($name).'</h2><ul>
                    <li> Description: '.htmlspecialchars($description).'</li>
                    <li> Email: '.htmlspecialchars($email).'</li>
                    <li> Phone: '.htmlspecialchars($phone).'</li>
                    <li><a href="profile.php?name='.urlencode($name).'&type=enterprise">Go to profile</a></li>';
        if ($editable) {
            echo   '<li><a href="edit.php?key1='.urlencode($name).'&type=enterprise"> edit </a></li>
                    <li><a href="uploads/delete.php?type=enterprise&key1='.urlencode($name).'"> delete </a></li>';
        }
        echo      '</ul></article>';
    }

    function echoNotification($class, $titleClass, $description, $room, $hotel, $time) {
        echo    '<article class="'.$class.'">
                    <p class="'.$titleClass.' title">'.htmlspecialchars($room).' - '.$time.'</p>
                    <p> Hotel: '.htmlspecialchars($hotel).'</p>
                    <p> Description: '.$description.' </p>
                    </article>';
    }

    function echoMessage($user, $message, $time) {
        if ($user == $_SESSION["name"]) {
            $mclass = "RightMessage";
            $uclass = "Right";
        } else  {
            $mclass = "LeftMessage";
            $uclass = "Left";
        }
        echo 
        '<p class="'.$uclass.'">'.htmlspecialchars($user).' '.$time.'</p>
            <p class="'.$mclass.'">'.htmlspecialchars($message).'</p>';
    }

    function echoRating($ratedby, $review, $rating) {
        echo    '<article class="RoomNonFloat">
                <h2 class="Room-Title title">'.htmlspecialchars($ratedby).'</h2>
                <p> Review: '.htmlspecialchars($review).' </p>
                <p> Rating: '.$rating.' stars </p>
                </article>';
    }

    function echoBooking($bookedby, $startdate, $enddate, $room, $hotel) {
        echo    '<article class="Room">
                <h2 class="Room-Title title">'.htmlspecialchars($bookedby).'</h2>
                <a href="profile.php?name='.urlencode($bookedby).'&type=user">Go to profile</a>
                <a href="message.php?user='.urlencode($bookedby).'">Send a message</a>
                <p> Hotel: '.htmlspecialchars($hotel).' -  Room: '.htmlspecialchars($room).'</p>
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
            if (!$sth->execute())
                throw new PDOException('An error occurred');
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
            if (!$sth->execute())
                throw new PDOException('An error occurred');
            while ($row = $sth->fetch( PDO::FETCH_ASSOC ) ) {
                echoRoom($boxId, $titleId, $row["name"], $row["belongstoenterprise"], $row["belongstohotel"], $row["cost"], $row["description"], $row["startdate"], $row["enddate"], $row["timeslotmax"], $row["long"], $row["lat"], $canBeBooked, $editable);
                if ($isBooked) {
                    $dayDiff = round((strtotime($row["endd"]) - strtotime($row["startd"])) / (60 * 60 * 24));;
                    $totalCost = $dayDiff * (int) $row["cost"];
                    echo '<div class="subBooking"><p> Booked from: '.$row["startd"].' to '.$row["endd"].'</p><p> Days staying: '.$dayDiff.' </p><p> Total cost: €'.$totalCost.' </p>
                          <a href="uploads/deleteBooking.php?room='.urlencode($row["name"]).'&hotel='.urlencode($row["belongstohotel"]).'"> cancel this booking </a></div>';
                }
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
            if (!$sth->execute())
                throw new PDOException('An error occurred');
            while ($row = $sth->fetch( PDO::FETCH_NUM ) ) {
                if ($isUser)
                    echoUser($boxId, $titleId, $row[0], $row[1], $editable);
                else {
                    echoEnterprise($boxId, $titleId, $row[0], $row[1], $row[2], $row[3], $editable);
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
            if (!$sth->execute())
                throw new PDOException('An error occurred');
            while ($row = $sth->fetch( PDO::FETCH_ASSOC ) ) {
                echoBooking($row["bookedby"], $row["startd"], $row["endd"], $row["roomname"], $row["hotelname"]);
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
            if (!$sth->execute())
                throw new PDOException('An error occurred');
            while ($row = $sth->fetch( PDO::FETCH_ASSOC ) ) {
                if ($isRoom)
                    echoRoom("Room", "Room-Title", $row["name"], $row["belongstoenterprise"], $row["belongstohotel"], $row["cost"], $row["description"], $row["startdate"], $row["enddate"], $row["timeslotmax"], $row["long"], $row["lat"], true);
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
            $sth = $conn->prepare("SELECT * FROM notifications WHERE sentto = :name ORDER BY time");
            $sth->bindParam(':name', $_SESSION["name"], PDO::PARAM_STR, strlen($_SESSION["name"]));
            if (!$sth->execute())
                echo '<p> error getting notifications </p>';
            while ($row = $sth->fetch(PDO::FETCH_NUM)) {
                echoNotification("RoomNonFloat", "Room-Title", $row[1], $row[2], $row[3], $row[4]);
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
            $sth->bindParam(':userone', $one, PDO::PARAM_STR, strlen($one));
            $sth->bindParam(':useroneone', $one, PDO::PARAM_STR, strlen($one));
            $sth->bindParam(':usertwo', $two, PDO::PARAM_STR, strlen($two));
            $sth->bindParam(':usertwotwo', $two, PDO::PARAM_STR, strlen($two));
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
            $sth->bindParam(':date', $date, PDO::PARAM_STR, strlen($date));
            if (!$sth->execute())
                echo '<p> error getting data </p>';
            while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                echoRoom("Room", "Room-Title", $row["name"], $row["belongstoenterprise"], $row["belongstohotel"], $row["cost"], $row["description"], $row["startdate"], $row["enddate"], $row["timeslotmax"], $row["long"], $row["lat"], true);
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
            if (!$sth->execute())
                throw new PDOException('An error occurred');
            $row = $sth->fetch( PDO::FETCH_NUM );
            echo '<p class="title">Hotel:</p>';
            echoHotel("RoomNonFloat", "Room-Title", $row[1], $row[0], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);
            echo '<p class="title">Room:</p>';
            echoRoom("RoomNonFloat", "Room-Title", $row[9], $row[0], $row[1], $row[11], $row[10], $row[12], $row[13], $row[14], $row[15], $row[16], false);
            
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

    /**
     * upload one image at a time
     * tmp = tmp name of the file
     * img = the real name of the file
     * size = size
     * name = new prefix of the image file for on server
     * type = new postfix of the image file for on server
     */
    function uploadOneImage($tmp, $img, $size, $name, $type) {
        if (!empty($tmp) && !empty($img) && !empty($size)) {
            $name = md5($name);
            $target_dir = "images/";
            $usersFileName = $tmp;
            $imageType = strtolower(pathinfo($img,PATHINFO_EXTENSION));
            $url = $_POST["url"];
            //echo "<p>$usersFileName + $imageType</p>";

            //CHECKS BEFOREHAND
            if($imageType != "jpg" && $imageType != "png" && $imageType != "jpeg") {
                header("location: $url?error=".urlencode('<p>png, jpg, jpeg files are only allowed. Go back and retry.</p>'));
                die();
            }
            $sizeInfo = getImageSize($usersFileName);
            if ($sizeInfo[0] > 1000 || $sizeInfo[1] > 1000) {
                header("location: $url?error=".urlencode('<p>Your image is bigger than 500x500. Go back and retry.</p>'));
                die();
            }
            if ($size > 50000000) {
                header("location: $url?error=".urlencode('<p>your file is larger than 50000000kb. Go back and retry.</p>'));
                die();
            }
            
            //GENERATING IMAGE NAME
            $i = 0;
            while (file_exists($target_dir.$name."_".$type."_".$i.".jpg")) {
                $i = $i+1;
            }
            $newName = $name."_".$type."_".$i.".jpg";
            //echo "<p>choses as i: $i </p><p> $newName </p>";

            //MAKING TARGET DIR
            $target_file=$target_dir.$newName;
            //echo "<p>chosen as target file: $target_file</p>";
            if (isset($_POST["submit"])) {
                if (!move_uploaded_file($usersFileName,$target_file)) {
                    echo "<p>file not added </p>";
                }
            }
        }
    }

    /**
     * upload one video at a time
     * tmp = tmp name of the file
     * img = the real name of the file
     * size = size
     * name = new prefix of the video file for on server
     * type = new postfix of the video file for on server
     */
    function uploadOneVideo($tmp, $img, $size, $name, $type) {
        if (!empty($tmp) && !empty($img) && !empty($size)) {
            $name = md5($name);
            $target_dir = "videos/";
            $usersFileName = $tmp;
            $videoType = strtolower(pathinfo($img,PATHINFO_EXTENSION));
            $url = $_POST["url"];
            //echo "<p>$usersFileName + $imageType</p>";

            //CHECKS BEFOREHAND
            if($videoType != "mv4" && $videoType != "mp4") {
                header("location: $url?error=".urlencode('<p>mv4, mp4 files are only allowed. Go back and retry.</p>'));
                die();
            }
            if ($size > 50000000000) {
                header("location: $url?error=".urlencode('<p>your file is larger than 50000000000kb. Go back and retry.</p>'));
                die();
            }

            //GENERATING IMAGE NAME
            $i = 0;
            while (file_exists($target_dir.$name."_".$type."_".$i.".mp4")) {
                $i = $i+1;
            }
            $newName = $name."_".$type."_".$i.".mp4";
            //echo "<p>choses as i: $i </p><p> $newName </p>";

            //MAKING TARGET DIR
            $target_file=$target_dir.$newName;
            //echo "<p>chosen as target file: $target_file</p>";
            if (isset($_POST["submit"])) {
                if (!move_uploaded_file($usersFileName,$target_file)) {
                    header("location: $url?error=".urlencode('<p>File not uploaded because of an error. Go back and retry.</p>'));
                    die();
                }
            }
        }
    }

    function showImages($name, $type) {
        $name = md5($name);
        $i = 0;
        while(file_exists("uploads/images/".$name."_".$type."_".$i.".jpg")) {
            echo '<img class="uploadedImage" src="uploads/images/'.$name."_".$type."_".$i.'.jpg" alt="user uploaded image" width="70" height="70">';
            $i += 1;
        }
    }

    function showVideos($name, $type) {
        $name = md5($name);
        $i = 0;
          while(file_exists("uploads/videos/".$name."_".$type."_".$i.".mp4")) {
            echo '  <video class="uploadedImage" width="150" height="150" controls>
                        <source src="uploads/videos/'.$name."_".$type."_".$i.'.mp4" type="video/mp4">
                    unsupported in browser
                    </video>';
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


    function checkSession($logged, $check, bool $type, $url = "error.php", $description = "Error! Session Expired") {
        //Session not expired and not ADMIN
        if ($_SESSION["admin"] != true) {
            if ($type) {
                if ($logged == $check) {
                    header("location: $url?error=".urlencode($description));
                    die();
                }
            } else {
                if ($logged != $check) {
                    header("location: $url?error=".urlencode($description));
                    die();
                }
            }
        }
    }

    /*
    function stayLoggedIn($name, $type) {
        try {
            echo "$name, $type";
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("INSERT INTO cookies 
            (name, type) 
            VALUES 
            (:name, :type);");
            $sth->bindParam(':name', $name, PDO::PARAM_STR, strlen($name));
            $sth->bindParam(':type', $type, PDO::PARAM_STR, strlen($type));
            setcookie("user_id", "3", time() + (86400 * 80));
            if (!$sth->execute())
                echo "<p> error with inserting </p>";
                //throw new PDOException('An Error has occurred');
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function checkStayLoggedIn() {
        try {
            echo "connecting: ";
            $cookieId = $_COOKIE["user_id"];
            echo $cookieId;
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("SELECT * FROM cookies WHERE cookies.id = :id");
            $sth->bindParam(':id', $cookieId, PDO::PARAM_STR, strlen($cookieId));
            if (!$sth->execute()) {
                echo "<p> error with query </p>";
                throw new PDOException('An Error has occurred');
            }
            echo "<p> query succesfull </p>";
            $row = $sth->fetch(PDO::FETCH_ASSOC);
            $_SESSION["name"] = $row["name"];
            $_SESSION["typeLogged"] = $row["type"];
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }
    */
    
?>