<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BOOKING_APPOINTMENT";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $hash_pwd = hash('sha512', 'byebye');
        $sql2 = "INSERT INTO users (fullName, email, password,role) VALUES ('Le Jimmy Trong', 'kien.le123@hcmut.edu.vn', '$hash_pwd','1')";
        $result2 = $conn->query($sql2);
    };
?>