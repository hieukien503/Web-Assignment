<?php
include("dbConnector.php");
include("sendMail.php");

session_start();
function bookingAppointment($date, $timeslot)
{ 
    global $DB_CONNECTOR;
    $sql3 = "SELECT * FROM appointment WHERE appointment_timeslot='$timeslot' AND appointment_date = '$date' AND appointment_status ='O' AND appointment_doctorID ='{$_SESSION['doctorID']}'";
    $result3 = $DB_CONNECTOR->query($sql3);
    if ($result3->num_rows > 0) return false;
    $sql4 = "SELECT * FROM appointment WHERE appointment_timeslot='$timeslot' AND appointment_date = '$date' AND appointment_status ='O' AND appointment_patientID ='{$_SESSION['id']}'";
    $result4 = $DB_CONNECTOR->query($sql4);
    if ($result4->num_rows > 0) return false;
    $sql = "UPDATE appointment SET appointment_status='O' WHERE appointment_timeslot='$timeslot' AND appointment_date = '$date' AND appointment_doctorID ='{$_SESSION['doctorID']}'";
    $sql2   = "UPDATE appointment SET appointment_patientID = '{$_SESSION['id']}' WHERE appointment_timeslot='$timeslot' AND appointment_date = '$date' AND appointment_doctorID ='{$_SESSION['doctorID']}'";
    $result = $DB_CONNECTOR->query($sql);
    $result2 = $DB_CONNECTOR->query($sql2);
    return $result && $result2;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dateapp']) && isset($_POST['timeslot'])) {
        if (bookingAppointment($_POST['dateapp'], $_POST['timeslot'])) {
            $_SESSION['successful'] = true;
            $doctorID = $_SESSION['doctorID'];
            $patientID = $_SESSION['id'];
            $patientInfo = $DB_CONNECTOR->query("SELECT fullName, email FROM users WHERE userID='$patientID'")->fetch_assoc();
            $doctorInfo = $DB_CONNECTOR->query("SELECT fullName, email FROM users WHERE userID='$doctorID'")->fetch_assoc();
            $appointmentInfo = $DB_CONNECTOR->query("SELECT appointment_timeslot, appointment_date FROM appointment WHERE appointment_timeslot='{$_POST['timeslot']}' AND appointment_date = '{$_POST['dateapp']}' AND appointment_doctorID ='{$_SESSION['doctorID']}'")->fetch_assoc();
            sendMail($patientInfo['email'], $patientInfo['fullName'], $doctorInfo['email'], $doctorInfo['fullName'], $appointmentInfo['appointment_timeslot'], $appointmentInfo['appointment_date'],);
            sendMailforDoctor($patientInfo['email'], $patientInfo['fullName'], $doctorInfo['email'], $doctorInfo['fullName'], $appointmentInfo['appointment_timeslot'], $appointmentInfo['appointment_date'],);
            header("Location: ../index.php");
            exit();
        } else {
            echo '<script type="text/javascript">window.alert("You can not meet 2 doctor at a time!")</script>';
            $_SESSION['notgud'] = true;
            header("Location: ../index.php");
        }
    } else {
        echo "<script>Please provide both username and password</script>";
        header("Location: ../login.php");
    }
}
?>