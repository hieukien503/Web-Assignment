<?php
include("dbConnector.php");
include("sendMail.php");

session_start();
function deletingAppointment($date, $timeslot)
{
    global $DB_CONNECTOR;

    $sql = "UPDATE appointment SET appointment_status='I' WHERE appointment_timeslot='$timeslot' AND appointment_date = '$date' AND appointment_doctorID ='{$_SESSION['doctorID']}'";
    $result = $DB_CONNECTOR->query($sql);
    $DB_CONNECTOR->disconnect();
    return $result;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['appointdate']) && isset($_POST['timeslotpatient'])) {
        $doctorID = $_SESSION['doctorID'];
        $appointmentInfo = $DB_CONNECTOR->query("SELECT * FROM appointment WHERE appointment_timeslot='{$_POST['timeslotpatient']}' AND appointment_date = '{$_POST['appointdate']}' AND appointment_doctorID ='{$_SESSION['doctorID']}'")->fetch_assoc();
        if ($appointmentInfo['appointment_status'] == 'O') {
            $patientInfo = $DB_CONNECTOR->query("SELECT fullName, email FROM users WHERE userID='{$appointmentInfo['appointment_patientID']}'")->fetch_assoc();
            $doctorInfo = $DB_CONNECTOR->query("SELECT fullName, email FROM users WHERE userID='$doctorID'")->fetch_assoc();
            sendMailCancelforDoctor($patientInfo['email'], $patientInfo['fullName'], $doctorInfo['email'], $doctorInfo['fullName'], $appointmentInfo['appointment_timeslot'], $appointmentInfo['appointment_date'],);
        }
        if (deletingAppointment($_POST['appointdate'], $_POST['timeslotpatient'])) {
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
