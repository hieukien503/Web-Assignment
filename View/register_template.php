<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/light_style.css">

  <!--Bootstrap 5 CDN-->
  <!-- Latest compiled and minified CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Latest compiled JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

  <title>Login</title>
</head>

<body>
  <header>
    <a href="../index.html"><img src="../img/logo/800x800.png" class="logo"></a>
  </header>
  <div
    style="background-image: url(../img/logo/light_1080.png); background-size: cover; height: 100%; display: flex; justify-content: center; align-items: center;">
    <div class="card border-dark mb-3 form">
      <div class="card-header">Sign Up</div>
      <div class="card-body text-dark">
        <form id="myForm" onsubmit="return validateForm()" action="../auth/signup_processing.php" method="post">
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="text" name="email" class="form-control" id="email" required>
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" onkeyup='check();' required>
            <div id="passwordHelp" class="form-text">Password must be atleast 8 characters long. Example: 12345678</div>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" onkeyup='check();' required>
          </div>
          <span id="message"></span>
          <div class="mb-3" style=" width: 100%;">
            <a href="login.php" class="card-link" style="display: flex; float:right">Already have an account?</a>
          </div>
          <button type="submit" id="submit" style="cursor: not-allowed;" class="btn btn-dark">Submit</button>
        </form>
      </div>
    </div>
  </div>
</body>
<script>
  function check() {
    if (document.getElementById('password').value >= 8 && document.getElementById('password').value ==
      document.getElementById('confirmPassword').value) {
      document.getElementById('message').style.color = 'green';
      document.getElementById('message').innerHTML = 'Password Matched';
      document.getElementById('submit').style.cursor = 'pointer';
    } else {
      document.getElementById('message').style.color = 'red';
      document.getElementById('message').innerHTML = 'Password not matching or less than 8 characters';
      document.getElementById('submit').style.cursor = 'not-allowed';
    }
  }

  function validateForm() {
    let x = document.forms["myForm"]["email"].value;
    let mailformat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

    if (x.match(mailformat) == null) {
      alert("Invalid Email");
      return false;
    };
    let y = document.forms["myForm"]["password"].value;
    if (y.length < 8) {
      alert("Password must be longer than 8 characters");
      return false;
    };
  }

</script>

</html>