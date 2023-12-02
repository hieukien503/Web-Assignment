<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        include("initDB.php");
        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($fullname) || empty($email) || empty($password)) {
            $_SESSION['msg'] = 'All fields must be filled';
            header('../View/register.php');
        } else if (strlen($password) < 8) {
            $_SESSION['msg'] = 'Password must be 8 characters or longer';
            header('../View/register.php');
        } else if (!preg_match("/^[_.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+.)+[a-zA-Z]{2,6}$/i", $email)) {
            $_SESSION["msg"] = "Invalid Email";
            header('../View/register.php');
        } else
            ;

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