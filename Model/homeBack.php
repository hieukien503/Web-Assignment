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
// This function is to check the slot is set by that doctor or not
function checkTime($ts, $dt)
{
    global $DB_CONNECTOR;
    if (!isset($_SESSION['doctorID'])){
    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt'";
    }else{
    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt' AND appointment_doctorID = '{$_SESSION['doctorID']}'";
    }
    $result = $DB_CONNECTOR->query($sql);

    if ($result->num_rows > 0) return true;
    return false;
}
// This function is to check the slot is occupied by the patient user
function checkMyappointment($ts, $dt)
{
    global $DB_CONNECTOR;
    if (isset($_SESSION['doctorID'])){
    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt' AND appointment_status ='O' AND appointment_patientID ='{$_SESSION['id']}' AND appointment_doctorID = '{$_SESSION['doctorID']}'";}
    else{
    include("initDB.php");
    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt' AND appointment_status ='O' AND appointment_patientID ='{$_SESSION['id']}'";
    }
    $result = $DB_CONNECTOR->query($sql);

    if ($result->num_rows > 0) return true;
    return false;
}
// This function is to check the slot is occupied by the doctor user
function checkMyappointment2($ts, $dt)
{
    global $DB_CONNECTOR;

    include("initDB.php");
    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt' AND appointment_status ='O' AND appointment_doctorID ='{$_SESSION['id']}'";
    $result = $DB_CONNECTOR->query($sql);

    if ($result->num_rows > 0) return true;
    return false;
}
// this function is to avoid checking null patientID, and check the occupied slot by the others
function checkOccupiedAppointment($ts, $dt)
{
    global $DB_CONNECTOR;

    if (isset($_SESSION['doctorID'])){
    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt' AND appointment_status ='O' AND appointment_doctorID ='{$_SESSION['doctorID']}'";
    }else{
        $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt' AND appointment_status ='O'";
    }
    $result = $DB_CONNECTOR->query($sql);

    include("initDB.php");
    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt' AND appointment_status ='O'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) return true;
    return false;
}

function getPatientName($ts, $dt)
{
    global $DB_CONNECTOR;
    if (isset($_SESSION['doctorID'])){
    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt' AND appointment_doctorID = '{$_SESSION['doctorID']}'";
    }else{
        $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt'";
    }$result = $DB_CONNECTOR->query($sql);
    include("initDB.php");
    $sql = "SELECT * FROM appointment WHERE appointment_timeslot='$ts' AND appointment_date = '$dt'";
    $result = $conn->query($sql);
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

function getListDoctor()
{
    global $DB_CONNECTOR;
    $sql = "SELECT * FROM users WHERE role = 1";
    $result = $DB_CONNECTOR->query($sql);

    return $result;
}
function getDoctorName(){
    global $DB_CONNECTOR;
    if  (isset($_SESSION['doctorID'])){
    $sql = "SELECT * FROM users WHERE userID = '{$_SESSION['doctorID']}'";
    $result = $DB_CONNECTOR->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
            return $row['fullName'];
        }}
    return "No Doctor Name";
}
?>
