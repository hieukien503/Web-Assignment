<?php

session_start();

function addingAppointment($date,$timeslot)
{ 
    include("connectDB.php");
    $sql = "INSERT INTO appointment (appointment_date, appointment_timeslot, appointment_doctorID, appointment_status)
    VALUES ('$date', '$timeslot', '{$_SESSION['id']}', 'I')";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dateappoint']) && isset($_POST['timeslotdoctor'])) {
        if (addingAppointment($_POST['dateappoint'], $_POST['timeslotdoctor'])) {
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