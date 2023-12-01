<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: index.php?page=home");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel= "stylesheet" href="./View/login.css">
</head>
<body>
    <div id="signin" class="container text-center">
        <h1>Sign in</h1>
        <form id="form" method="post" action="../Model/login_processing.php">
            <div class="input-icons">
                <input type="text" placeholder="Email address" id="email" name="email" autocomplete="off" required>
                <i class="fa fa-envelope icon"></i>
            </div>
            <div class="input-icons">
                <input type="password" placeholder="Password" id="passwrd" name="password" autocomplete="off" required>
                <i class="fa fa-lock icon"></i>
            </div>
            <a id="forget_pass" href="#">Forget Password?</a><br>
            <button type="submit" id="signin-btn" class="btn btn-light">Sign in</button><br>
            <span>Don't have an account? <a href="./index.php?page=register">Register</a></span>
        </form>
    </div>
</body>
</html>