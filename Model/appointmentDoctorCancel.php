<?php
include("dbConnector.php");


session_start();
function deleteAppointment($date,$timeslot)
{ 
    global $DB_CONNECTOR;
    $sql = "DELETE FROM appointment WHERE appointment_date = '$date' AND appointment_timeslot = '$timeslot'";
    $result = $DB_CONNECTOR->query($sql);
    $DB_CONNECTOR->disconnect();
    return $result;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dateappoint2']) && isset($_POST['timeslotdoctor2'])) {
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
?>