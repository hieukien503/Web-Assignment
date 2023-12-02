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
  <link rel="stylesheet" href="./View/login.css">

</head>

<body>
  <div id="signin" class="container text-center">
    <h1>Sign in</h1>
    <form id="form" method="post" action="./Model/login_processing.php" onsubmit="return validateForm()">
      <div class="input-icons">
        <input type="text" placeholder="Email address" id="email" name="email" autocomplete="off" required>
        <i class="fa fa-envelope icon"></i>
      </div>
      <div id="invalid-mail" class="form-text" style="display: none; color: red;">Invalid Email</div>
      <div class="input-icons">
        <input type="password" placeholder="Password" id="passwrd" name="password" autocomplete="off" required>
        <i class="fa fa-lock icon"></i>
      </div>
      <div id="invalid-pwd" class="form-text" style="display: none; color: red;">Password must be
        atleast 8 characters long.</div>
      <a id="forget_pass" href="#">Forget Password?</a><br>
      <button type="submit" id="signin-btn" class="btn btn-light" name="login">Sign in</button><br>
      <span>Don't have an account? <a href="./index.php?page=register">Register</a></span>
    </form>
  </div>
</body>
<script>
  function validateForm() {
    let x = document.forms["form"]["email"].value;
    let mailformat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

    if (x.match(mailformat) == null) {
      document.getElementById('invalid-pwd').style.display = 'none';
      document.getElementById('invalid-mail').style.display = 'block';
      return false;
    } else {
      document.getElementById('invalid-mail').style.display = 'none';
    };
    let y = document.forms["form"]["passwrd"].value;
    if (y.length < 8) {
      document.getElementById('invalid-pwd').style.display = 'block';
      return false;
    };
  }
</script>

</html>