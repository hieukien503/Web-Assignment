<?php
$duration = 30;
$cleanup = 0;
$start = "17:00";
$end = "23:00";

function timeslots($duration, $cleanup, $start, $end)
{
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT" . $duration . "M");
    $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
    $slots = array();

    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if ($endPeriod > $end) {
            break;
        }
        $slots[] = $intStart->format("H:iA") . " - " . $endPeriod->format("H:iA");
    }
    return $slots;
}

// below function is to check if the timeslot is expired or not
function checkExpire($slot)
{
    list($startTime, $endTime) = explode(" - ", $slot);
    $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
    $currentTime = new DateTime('now', $timezone);
    $dt = $currentTime->format("H:iA");
    return $dt >= $startTime;
}
?>
