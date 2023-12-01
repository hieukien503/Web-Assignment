<?php


function deleteAppointment($date,$timeslot)
{ 
    include("connectDB.php");
    $sql = "DELETE FROM appointment WHERE appointment_date = '$date' AND appointment_timeslot = '$timeslot'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dateappoint2']) && isset($_POST['timeslotdoctor2'])) {
        if (deleteAppointment($_POST['dateappoint2'], $_POST['timeslotdoctor2'])) {
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