<?php

session_start();

function loginVerification($email,$passwording)
{ 
    include("connectDB.php");
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($passwording == $row['password']) {
            if ($row['role'] == '0') $_SESSION['role'] = false;
            else $_SESSION['role'] = true;
            $_SESSION['fullName'] = $row['fullName'];
            $_SESSION['id'] = $row['userID'];
            $_SESSION['email'] = $row['email'];
            $conn->close();
            return true;
        }
    }
    $conn->close();
    return false;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        if (loginVerification($_POST['email'], $_POST['password'])) {
            $_SESSION['login'] = true;
            header("Location: ../index.php");
            exit();
        } else {
            echo "<script>window.alert(Invalid username or password)</script>";
            header("Location: ../login.php");
        }
    } else {
        echo "<script>Please provide both username and password</script>";
        header("Location: ../login.php");
    }
}
?>