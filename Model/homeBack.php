<?php
include("dbConnector.php");


$duration = 30;
$cleanup = 0;
$start = "16:00";
$end = "23:30";
session_start();
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

function checkTime($ts, $dt)
{
    global $DB_CONNECTOR;

    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt'";
    $result = $DB_CONNECTOR->query($sql);
    if ($result->num_rows > 0) return true;
    return false;
}
function checkMyappointment($ts, $dt)
{
    global $DB_CONNECTOR;

    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt' AND appointment_status ='O' AND appointment_patientID ='{$_SESSION['id']}'";
    $result = $DB_CONNECTOR->query($sql);
    if ($result->num_rows > 0) return true;
    return false;
}
function checkMyappointment2($ts, $dt)
{
    global $DB_CONNECTOR;

    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt' AND appointment_status ='O' AND appointment_doctorID ='{$_SESSION['id']}'";
    $result = $DB_CONNECTOR->query($sql);
    if ($result->num_rows > 0) return true;
    return false;
}
// this function is to avoid checking null patientID
function checkOccupiedAppointment($ts, $dt)
{
    global $DB_CONNECTOR;

    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt' AND appointment_status ='O'";
    $result = $DB_CONNECTOR->query($sql);
    if ($result->num_rows > 0) return true;
    return false;
}

function getPatientName($ts, $dt)
{
    global $DB_CONNECTOR;

    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt'";
    $result = $DB_CONNECTOR->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $sql2 = "SELECT * FROM users WHERE userID='{$row['appointment_patientID']}'";
        $result2 = $DB_CONNECTOR->query($sql2);
        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
                return $row2['fullName'];
        }
    }
    return "No Patient";
}
?>
