<?php
include("dbConnector.php");


session_start();
function bookingAppointment($date,$timeslot)
{ 
    global $DB_CONNECTOR;
    $sql = "UPDATE appointment SET appointment_status='O' WHERE appointment_timeslot='$timeslot' AND appointment_date = '$date'";
    $sql2   =   "UPDATE appointment SET appointment_patientID = '{$_SESSION['id']}' WHERE appointment_timeslot='$timeslot' AND appointment_date = '$date'";
    $result = $DB_CONNECTOR->query($sql);
    $result2 = $DB_CONNECTOR->query($sql2);
    $DB_CONNECTOR->disconnect();
    return $result&&$result2;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dateapp']) && isset($_POST['timeslot'])) {
        if (bookingAppointment($_POST['dateapp'], $_POST['timeslot'])) {
            $_SESSION['successful'] = true;
            header("Location: ../index.php");
            exit();
        } else {
            echo "<script>window.alert(Invalid username or password)</script>";
            echo "notgood";
        }
    } else {
        echo "<script>Please provide both username and password</script>";
        header("Location: ../login.php");
    }
}
?>