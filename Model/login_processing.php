<!-- trong file này bởi vì e chưa tạo hashed password trong register_processing nên e ms check kiểu chưa đc hash thui -->
<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once("dbConnector.php");

session_start();

function loginVerification($email, $hashed_password)
{

    // Use singleton DB_CONNECTOR from "dbConnector.php"
    global $DB_CONNECTOR;

    $result = $DB_CONNECTOR->query("SELECT * FROM users WHERE email = '$email'");

    if ($result->num_rows > 0) {
        // If account exists

        $_SESSION["exist"] = true;
        $row = $result->fetch_assoc();

        if ($hashed_password === $row['password']) {
            grantUserSession($row);

            $DB_CONNECTOR->disconnect();
            return true;
        }
    }

    $_SESSION["exist"] = false;
    $DB_CONNECTOR->disconnect();
    return false;
}

function grantUserSession($row)
{
    if ($row['role'] == '0') {
        $_SESSION['role'] = false;
        $_SESSION['doctorID'] = '1';
    } else if ($row['role'] == '1') {
        $_SESSION['role'] = true;
        $_SESSION['doctorID'] = $row['userID'];
    } else {
        $_SESSION['role'] = false;
    }

    $_SESSION['fullName'] = $row['fullName'];
    $_SESSION['id'] = $row['userID'];
    $_SESSION['email'] = $row['email'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $hash_pwd = hash('sha512', $_POST['password']);
        if (loginVerification($_POST['email'], $hash_pwd)) {
            $_SESSION['login'] = true;
            $_SESSION['initDB'] = true;
            header("Location: ../index.php");
        } else {
            /**
             * TO-DO: handle invalid account.
             * 
             * NKhoa suggests that an invalid message will be displayed next to 
             * the original login window on login.php. It should not just have an alert box, its not good UI.
             * 
             * Also, when navigate back to the login page, user should have the username field filled already,
             * they do not have to fill the login again.
             * 
             * And, fail cases of WRONG PASSWORD and INVALID ACCOUNT should be handled different (display different message).
             * 
             * Use $_GET[] will work!
             */

            if ($_SESSION["exist"]) {
                // If account exists
                $_SESSION['msg'] = 'Wrong Password!';
                $_SESSION['prefill'] = $_POST['email'];
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                $_SESSION['msg'] = "Invalid Account!";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }

        }
    }
}
?>