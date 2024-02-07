<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <link rel="stylesheet" href="main.css">
    <link rel="icon" href="logo.png" type="image/x-icon">
    <script  src="register/jquery-3.6.4.js"></script>
    <script>
        // Disable navigation arrows
        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
            history.pushState(null, null, document.URL);
        });
      function checkpass(pass) {
        var emailInput = document.getElementById("email");
        var spanElement = document.getElementById("pspan");
        $.ajax({
          url: 'logcheck.php',
          type: 'POST',
          data: {
              pass: pass,
              email: emailInput.value
              },
          success: function(response) {
            if (response == 'exists') {
        
              emailInput.setCustomValidity("");
              spanElement.innerHTML = "";
            }else{
              emailInput.setCustomValidity("Enter valid email/password");
              spanElement.innerHTML = "invalid username/password";
            }
          }
        });
      }
    </script>
  </head>
  <body>
    <div class="bcenter">
      
      <form action="" method="POST">
        <div id="form2">
          <p id="heading">Good to see you<br> again!</p>
          <div class="input-container">
            <input type="email" name="email" id="email"  placeholder=" " required>
            <label for="email">e-mail</label>
            
          </div>
          
          <div class="input-container">
            <input type="Password" name="pass" id="pass" onchange="checkpass(this.value)" placeholder=" " required>
            <label for="pass">Password</label>
            <span class="mySpan" id="pspan"></span>
          </div>
          <p align="right"><a href="http://localhost/phpmyadmin/index.php?route=/sql&pos=0&db=docloc&table=rdetails">forgot password?</a></p>
          <input type="submit" name="login" value="Login" class="btn">
          <p align="center"><a href="register/register.html">new user?register now</a></p>
        </div>
      </form>
    </div>
  </body>
</html>
<?php
session_start();
$_SESSION['user'] = '';
if (isset($_POST['login']))
{
  $host = "localhost";
  $user = "root";
  $password = "";
  $database = "docloc";
  $connection = mysqli_connect($host, $user, $password, $database);
  $email=$_POST['email'];
  $pass=$_POST['pass'];
  $query = "SELECT pass FROM rdetails WHERE email = '$email'";
  $result = mysqli_query($connection, $query);
  $user = mysqli_fetch_assoc($result);
  if($user['pass']==$pass)
  {
    $_SESSION['user'] = $email;
    mysqli_close($connection);
    header('Location: Menu/menu.php');
    //echo '<script>window.location.href="";</script>';
    exit();
  }
  else{
    mysqli_close($connection);
    header('Location: login.php?error=invalid_password');
    exit();
  }
 
}
