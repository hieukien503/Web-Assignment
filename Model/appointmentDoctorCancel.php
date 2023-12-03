<?php
include("dbConnector.php");
include("sendMail.php");

session_start();
function deleteAppointment($date, $timeslot)
{
    global $DB_CONNECTOR;
    if (isset($_SESSION['doctorID'])) {
        $sql = "DELETE FROM appointment WHERE appointment_date = '$date' AND appointment_timeslot = '$timeslot' AND appointment_doctorID ='{$_SESSION['id']}'";
    } else {
        $sql = "DELETE FROM appointment WHERE appointment_date = '$date' AND appointment_timeslot = '$timeslot'";
    }
    $result = $DB_CONNECTOR->query($sql);
    return $result;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dateappoint2']) && isset($_POST['timeslotdoctor2'])) {
        $doctorID = $_SESSION['doctorID'];
        $appointmentInfo = $DB_CONNECTOR->query("SELECT appointment_timeslot, appointment_date, appointment_patientID,appointment_status FROM appointment WHERE appointment_timeslot='{$_POST['timeslotdoctor2']}' AND appointment_date = '{$_POST['dateappoint2']}' AND appointment_doctorID ='{$_SESSION['doctorID']}'")->fetch_assoc();
        if ($appointmentInfo['appointment_status'] == 'O') {
            $patientInfo = $DB_CONNECTOR->query("SELECT fullName, email FROM users WHERE userID='{$appointmentInfo['appointment_patientID']}'")->fetch_assoc();
            $doctorInfo = $DB_CONNECTOR->query("SELECT fullName, email FROM users WHERE userID='$doctorID'")->fetch_assoc();
            sendMailCancelforPatient($patientInfo['email'], $patientInfo['fullName'], $doctorInfo['email'], $doctorInfo['fullName'], $appointmentInfo['appointment_timeslot'], $appointmentInfo['appointment_date'],);
        }
        if (deleteAppointment($_POST['dateappoint2'], $_POST['timeslotdoctor2'])) {
            $_SESSION['delete'] = true;
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
