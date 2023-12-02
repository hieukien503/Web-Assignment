<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['register'])) {
            include("initDB.php");
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $hash_pwd = hash('sha512', $_POST['passwrd']);
            $sql = "SELECT * FROM users WHERE email = '$email'";
    
            // init db and establish connection
            $db = new InitDatabase();
            $conn = $db->conn;
                
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo '<script type="text/javascript">window.alert("Email address exists!")</script>';
                echo '<script type="text/javascript">window.location.replace("../index.php?page=register")</script>';
            }
            else {
                $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$hash_pwd')";
                if ($conn->query($sql) === TRUE) {
                    echo '<script type="text/javascript">window.alert("Register successfully!")</script>';
                    echo '<script type="text/javascript">window.location.replace("../index.php?page=login")</script>';
                }
            }
        }
    }
?>