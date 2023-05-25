<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <title>CodeGrinder-Your Coding Companion</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-image: url('pxfuel.jpg');
      background-size: cover;
      backdrop-filter: blur(5px);
      -webkit-backdrop-filter: blur(5px);
    }

    .container {
      text-align: center;
      background-color: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 4px;
      box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .btn {
      padding: 10px 20px;
      font-size: 16px;
      margin: 10px;
    }

    .login-box {
      display: none;
      margin-top: 20px;
    }

    .login-box h2 {
      margin-top: 0;
    }

    .form-group {
      margin-bottom: 10px;
      text-align: left;
    }

    .form-group label {
      display: block;
      font-weight: bold;
    }

    .form-group input {
      width: 90%;
      padding: 8px;
      font-size: 16px;
      border-radius: 4px;
      margin: 0 auto;
      /* Add this line to center the input boxes */
    }

    .form-group input[type="text"],
    .form-group input[type="password"],
    .form-group input[type="email"] {
      background-color: #f7f7f7;
      border: none;
      border: 1px solid #ced4da;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="password"]:focus,
    .form-group input[type="email"]:focus {
      border-color: #80bdff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .form-group input[type="submit"] {
      cursor: pointer;
    }

    .register-box {
      display: none;
      margin-top: 20px;
    }

    .register-box h2 {
      margin-top: 0;
    }

    .register-box .form-group label {}

    .register-box .form-group input {
      border: 1px solid black;
    }

    .register-box .form-group input[type="submit"] {
      cursor: pointer;
    }

    .success-message {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      padding: 10px;
      background-color: green;
      color: white;
      text-align: center;
      animation: slide-in 0.5s ease-out;
    }

    .unsuccess-message {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      padding: 10px;
      background-color: #d9534f;
      color: white;
      text-align: center;
      animation: slide-in 0.5s ease-out;
    }

    @keyframes slide-in {
      from {
        top: -50px;
        opacity: 0;
      }

      to {
        top: 0;
        opacity: 1;
      }
    }

    .container h1 {
      font-size: 60px;
      font-weight: bold;
      color: white;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
      /* transform: perspective(100px) rotateX(2.5deg); */
    }

    .container h1 span {
      display: inline-block;
      transform: perspective(100px) rotateX(20deg);
    }
  </style>
  <script>
    // JavaScript to show/hide the success message
    document.addEventListener("DOMContentLoaded", function () {
      var successMessage = document.querySelector(".success-message");
      var unsuccessMessage = document.querySelector(".unsuccess-message");
      if (successMessage) {
        successMessage.style.display = "block";
        setTimeout(function () {
          successMessage.style.display = "none";
        }, 3000); 
      }
      if (unsuccessMessage) {
        unsuccessMessage.style.display = "block";
        setTimeout(function () {
          unsuccessMessage.style.display = "none";
        }, 3000); 
      }
    });
    function showLoginBox() {
      document.getElementById("loginBox").style.display = "block";
      document.getElementById("registerForm").style.display = "none";
    }

    function showRegisterForm() {
      document.getElementById("registerForm").style.display = "block";
      document.getElementById("loginBox").style.display = "none";
    }
  </script>
</head>

<body>
  <?php if (isset($_SESSION["successMessage"])): ?>
    <div class="success-message">
      <?php echo $_SESSION["successMessage"]; ?>
    </div>
    <?php unset($_SESSION["successMessage"]); ?>
  <?php endif; ?>
  <?php if (isset($_SESSION["unsuccessMessage"])): ?>
    <div class="unsuccess-message">
      <?php echo $_SESSION["unsuccessMessage"]; ?>
    </div>
    <?php unset($_SESSION["unsuccessMessage"]); ?>
  <?php endif; ?>
  <div class="container">
    <h1>Welcome to Code<span>Grinder</span></h1>
    <div>
      <button class="btn btn-success" onclick="showLoginBox()">Login</button>
      <button class="btn btn-primary" onclick="showRegisterForm()">Register</button>
    </div>

    <div id="loginBox" class="login-box">
      <h2>Login</h2>
      <form action="login.php" method="POST">
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" class="form-control" required
            placeholder="Enter your username">
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" class="form-control" required
            placeholder="Enter your password">
        </div>
        <div class="form-group">
          <div class="text-center"> 
            <input type="submit" value="Login" class="btn btn-primary">
          </div>
        </div>
      </form>
    </div>

    <div id="registerForm" class="register-box">
      <h2>Registration</h2>
      <form action="register.php" method="POST">
        <div class="form-group">
          <label for="newUsername">Username:</label>
          <input type="text" id="newUsername" name="newUsername" class="form-control" required
            placeholder="Enter a username">
        </div>
        <div class="form-group">
          <label for="newPassword">Password:</label>
          <input type="password" id="newPassword" name="newPassword" class="form-control" required
            placeholder="Enter a password">
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" class="form-control" required placeholder="Enter your email">
        </div>
        <div class="form-group">
          <div class="text-center"> 
            <input type="submit" value="Register" class="btn btn-primary">
          </div>
        </div>
      </form>
    </div>
  </div>
</body>

</html>