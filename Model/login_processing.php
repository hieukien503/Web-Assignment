<!-- trong file này bởi vì e chưa tạo hashed password trong register_processing nên e ms check kiểu chưa đc hash thui -->
<?php

session_start();

function loginVerification($email, $passwording)
{
    global $DB_CONNECTOR;

    $hashed_password = hash('sha512', $passwording);

    $result = $DB_CONNECTOR->query("SELECT * FROM users WHERE email = '$email'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($passwording === $row['password']) {
            if ($row['role'] == '0')
                $_SESSION['role'] = false;
            else
                $_SESSION['role'] = true;
            $_SESSION['fullName'] = $row['fullName'];
            $_SESSION['id'] = $row['userID'];
            $_SESSION['email'] = $row['email'];
            $conn->close();
            return true;
        }
    }
    $conn->close();
    echo '<script type=text/javascript">window.alert("Invalid username or password")</script>';
    return false;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $hash_pwd = hash('sha512', $_POST['password']);
        if (loginVerification($_POST['email'], $hash_pwd)) {
            $_SESSION['login'] = true;
            echo '<script type=text/javascript">window.location.replace("../index.php?page=home")</script>';
        } else {
            echo '<script type=text/javascript">window.location.replace("../index.php?page=login")</script>';
        }
    }
}
?>