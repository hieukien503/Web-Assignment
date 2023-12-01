<?php

//AND appointment_patientID = null 
function deletingAppointment($date,$timeslot)
{ 
    include("connectDB.php");
    $sql = "UPDATE appointment SET appointment_status='I' WHERE appointment_timeslot='$timeslot' AND appointment_date = '$date'";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['appointdate']) && isset($_POST['timeslotpatient'])) {
        if (deletingAppointment($_POST['appointdate'], $_POST['timeslotpatient'])) {
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