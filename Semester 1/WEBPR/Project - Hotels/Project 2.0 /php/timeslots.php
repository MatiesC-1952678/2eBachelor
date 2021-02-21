<?php
function echoTimeslot($start, $timeslot, $room, $hotel) {
    $startDate = addInterval($start, 1);
    $endDate = addInterval($start, $timeslot);
    echo    '<article class="Room">
            <p class="Room-Title">'.$startDate.' - '.$endDate.'</p>
            <a href="booking.php?roomName='.urlencode($room).'&hotelName='.urlencode($hotel).'&start='.urlencode($startDate).'&end='.urlencode($endDate).'"> Book this timeslot </a>
            </article>';
}

function echoGap($start, $end) {
    echo    '<article class="Room">
            <p class="Room-Title red">'.$start.' - '.$end.'</p>
            <text> unavailable - booked </text>
            </article>';
}

function showTimeslots($sql, $room, $hotel) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare($sql);
            $sth->bindParam(':room', $room, PDO::PARAM_STR, strlen($room));
            $sth->bindParam(':hotel', $hotel, PDO::PARAM_STR, strlen($hotel));
            if (!$sth->execute())
                throw new PDOException('An error occurred');
            $row = $sth->fetch( PDO::FETCH_NUM );

            //SET VARIABLES
            $startDate = $row[2];
            $endDate = $row[3];
            $timeslot = $row[4];
            //echo "$startDate $endDate ";
            if (empty($startDate) || empty($endDate)) {
                //echo "I came here";
                $startDate = $row[0];
                $endDate = $row[1];
            }
            if (empty($timeslot)) {
                $timeslot = 5;
            }
            $dates = getBookingDates($room, $hotel);
            //echo "$startDate $endDate ";
            if (!empty($dates)) {
                makeTimeslotPeriod($startDate, $dates[0][0], $timeslot, $room, $hotel);
                echoGap($dates[0][0], $dates[0][1]);
                for ($i = 1; $i < count($dates); $i++) {
                    makeTimeslotPeriod($dates[$i-1][1], $dates[$i][0], $timeslot, $room, $hotel);
                    echoGap($dates[$i][0], $dates[$i][1]);
                }
                makeTimeslotPeriod($dates[count($dates)-1][1], $endDate, $timeslot, $room, $hotel);
            } else {
                makeTimeslotPeriod($startDate, $endDate, $timeslot, $room, $hotel);
            }

            
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function getBookingDates($room, $hotel) {
        try {
            $conn = new PDO( "pgsql:host=" . DB_HOST . ";port=5432;dbname=" . DB_NAME , DB_USER, DB_PASSWORD);
            $sth = $conn->prepare("SELECT startd,endd FROM bookings WHERE roomname = :room AND hotelname = :hotel");
            $sth->bindParam(':room', $room, PDO::PARAM_STR, strlen($room));
            $sth->bindParam(':hotel', $hotel, PDO::PARAM_STR, strlen($hotel));
            if (!$sth->execute())
                throw new PDOException('An error occurred');
            return $sth->fetchAll();
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage() . "\n";
            die();
        }
    }

    function makeTimeslotPeriod($start, $end, $timeslot, $room, $hotel) {
        $dayDiff = round((strtotime($end) - strtotime($start)) / (60 * 60 * 24));
        $slotAmount = floor($dayDiff/$timeslot);
        //echo "daydif: $dayDiff slotamount: $slotAmount start: $start end: $end timeslot: $timeslot";
        for ($i = 0; $i < $slotAmount; $i++) {
            $dayAmount = $i * $timeslot;
            echoTimeslot(addInterval($start, $dayAmount), $timeslot, $room, $hotel);
        }
        $endDay = $timeslot * $slotAmount;
        //echo "endday: $endDay daydiff%timeslot:".($dayDiff%$timeslot);
        if ($dayDiff%$timeslot  > 1)
            echoTimeslot(addInterval($start, $endDay), $dayDiff%$timeslot, $room, $hotel);
    }

    function addInterval($dateString, $dayAmount, $sign = "+") {
        return date('Y-m-d', strtotime($dateString. " $sign $dayAmount days"));
    }
?>