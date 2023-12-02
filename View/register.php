<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register an account</title>
    <link rel= "stylesheet" href="./View/register.css">
</head>
<body>
    <div id="register" class="container text-center">
        <h3>Register an account</h3>
        <form id="form" method="post" onsubmit="return validateForm()" action="./Model/register_processing.php">
            <div class="input-icons">
                <input type="text" placeholder="Full name" id="fullname" name="fullname" autocomplete="off" required>
                <i class="fa fa-user icon"></i>
            </div>
            <div class="input-icons">
                <input type="text" placeholder="Email address" id="email" name="email" autocomplete="off" required>
                <i class="fa fa-envelope icon"></i>
            </div>
            <div class="input-icons">
                <input type="password" placeholder="Password" id="passwrd" name="passwrd" autocomplete="off" required>
                <i class="fa fa-lock icon"></i>
                <div id="passwordHelp" class="form-text">Password must be atleast 8 characters long. Example: 12345678</div>
            </div>
            <button type="submit" id="register-btn" class="btn btn-light" name="register">CREATE AN ACCOUNT</button><br>
            <span>Already have an account? <a href="./index.php?page=login">Sign in</a></span>
        </form>
    </div>
</body>

<script>
  function validateForm() {
    let x = document.forms["form"]["email"].value;
    let mailformat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

    if (x.match(mailformat) == null) {
      alert("Invalid Email");
      return false;
    };
    let y = document.forms["form"]["password"].value;
    if (y.length < 8) {
      alert("Password must be longer than 8 characters");
      return false;
    };
  }

</script>

</html>