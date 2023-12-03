<?php
include("dbConnector.php");


session_start();

function addingAppointment($date, $timeslot)
{
    global $DB_CONNECTOR;

    $sql = "INSERT INTO appointment (appointment_date, appointment_timeslot, appointment_doctorID, appointment_status)
    VALUES ('$date', '$timeslot', '{$_SESSION['id']}', 'I')";
    $result = $DB_CONNECTOR->query($sql);
    $DB_CONNECTOR->disconnect();
    return $result;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dateappoint']) && isset($_POST['timeslotdoctor'])) {
        if (addingAppointment($_POST['dateappoint'], $_POST['timeslotdoctor'])) {
            $_SESSION['sucful'] = true;
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
