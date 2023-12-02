<?php
session_start();
$msg = '';
if (isset($_SESSION["msg"])) {
  $msg = $_SESSION["msg"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register an account</title>
  <link rel="stylesheet" href="./View/register.css">
</head>

<body>
  <div id="register" class="container text-center">
    <h3>Register an account</h3>

    <form id="form" method="post" onsubmit="return validateForm()" action="./Model/register_processing.php">
      <div id="msg" class="form-text" style="color: red;">
        <?php echo $msg ?>
      </div>
      <div class="input-icons">
        <input type="text" placeholder="Full name" id="fullname" name="fullname" autocomplete="off" required>
        <i class="fa fa-user icon"></i>
      </div>
      <div class="input-icons">
        <input type="text" placeholder="Email address" id="email" name="email" autocomplete="off" required>
        <i class="fa fa-envelope icon"></i>
      </div>
      <div id="invalid-mail" class="form-text" style="display: none; color: red;">Invalid Email</div>
      <div class="input-icons">
        <input type="password" placeholder="Password" id="passwrd" name="passwrd" autocomplete="off" required>
        <i class="fa fa-lock icon"></i>
      </div>
      <div id="invalid-pwd" class="form-text" style="display: none; color: red;">Password must be
        atleast 8 characters long.</div>
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