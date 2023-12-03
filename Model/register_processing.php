<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        include("initDB.php");
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $password = trim($_POST['passwrd']);

        // Server-side validation
        if (!preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/", $email)) {
            $_SESSION["msg"] = "Invalid Email";
            header("Location:" . $_SERVER['HTTP_REFERER']);
            die;
        } else if (strlen($password) < 8) {
            $_SESSION['msg'] = 'Password must be 8 characters or longer';
            header("Location:" . $_SERVER['HTTP_REFERER']);
            die;
        } else
            ;
        // end validation

        $hash_pwd = hash('sha512', $_POST['passwrd']);
        $sql = "SELECT * FROM users WHERE email = '$email'";

        // init db and establish connection
        $db = new InitDatabase();
        $conn = $db->conn;

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo '<script type="text/javascript">window.alert("Email address exists!")</script>';
            echo '<script type="text/javascript">window.location.replace("../index.php?page=register")</script>';
        } else {
            $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$hash_pwd')";
            if ($conn->query($sql) === TRUE) {
                echo '<script type="text/javascript">window.alert("Register successfully!")</script>';
                echo '<script type="text/javascript">window.location.replace("../index.php?page=login")</script>';
            }
        }
    }
}
?>