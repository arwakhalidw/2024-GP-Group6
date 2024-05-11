<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $email = strtolower($_POST['email']);
    $pass = $_POST['password'];
    $role = $_POST['role']; 
    
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "ADPrediction";

    $conn = new mysqli($servername, $username,$password , $dbname);
    $table = '';
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
	
	   $sql_check_physiologist_email = "SELECT * FROM physiologist WHERE email='$email'";
        $result_check_physiologist_email = mysqli_query($conn, $sql_check_physiologist_email);
        $sql_check_inquirer_email = "SELECT * FROM inquirer WHERE email='$email'";
        $result_check_inquirer_email = mysqli_query($conn, $sql_check_inquirer_email);

       if (mysqli_num_rows($result_check_physiologist_email) > 0 || mysqli_num_rows($result_check_inquirer_email) > 0) {
    // Email already registered
    echo '<script>alert("Email is already registered"); window.location.href = "registerPhysAndInq.php";</script>';
    exit;
}


    if ($role === 'physiologist') {
        $table = 'physiologist';
    } elseif ($role === 'inquirer') {
        $table = 'inquirer';
    }
	

    $sql = "INSERT INTO $table (name, email, password) VALUES ('$fullName', '$email', '$pass')";

    if ($conn->query($sql) === TRUE) {

        // Set the role in session
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email;
		
		if ($role==='physiologist')
		header("location: physHP.php");
	else
		header("location: InqHP.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <title>Predict Alzheimer's Disease</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
   <link href="sign-up.css" rel="stylesheet" type="text/css">
   <link href="index.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="script.js"></script>
  
  <style>
  body{
    background-image: url('img/3303725.jpg');
}
  </style>
</head>


<body id="home" data-spy="scroll" data-target=".navbar" data-offset="60">

    <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #490665;">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">
        <img src="img/logo.png" alt="logo">
      </a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
 <li><a href="index.php#about">ABOUT</a></li>
 <li><a href="index.php#mission">MISSION</a></li>
        <li><a href="checkRoleRegister.php">JOIN TODAY</a></li>
		<li><a href="checkRole.php">SIGN-IN</a></li>
      </ul>
    </div>
  </div>
</nav>



<!-- Container (Register Section) -->
<div id="register" class="container-fluid">
  <div class="container-signup">
    <div class="title">Registration</div>
    <div class="content">
      <form id="registrationForm" action="#" method="POST" onsubmit="return validateForm();">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Full Name</span>
            <input type="text" name="fullName" placeholder="Enter your name" onkeydown="return /[a-zA-Z\s]/i.test(event.key)" required>
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>
            <span id="emailError" style="display: none; color: red;">Invalid email format</span>
          </div>
          <div class="input-box">
			<span class="details">Password</span>
			<input id="password" name="password" type="password" placeholder="Enter your password" required>
			<span id="passwordErrorMessage" style="display: none; color: red;">Password must contain at least 1 capital letter, 1 number, and be at least 8 characters long.</span>
		</div>
          <div class="input-box">
            <span class="details">Confirm Password</span>
            <input id="confirmPassword" type="password" placeholder="Confirm password" required>
            <span id="passwordMatchMessage" style="display: none; color: red;">Passwords do not match</span>
          </div>
        </div>
        <div class="role-details">
          <input type="radio" name="role" value="physiologist" id="dot-1">
          <input type="radio" name="role" value="inquirer" id="dot-2">
          <span class="role-title">I Am A(n)</span>
          <div class="category">
            <label for="dot-1">
              <span class="dot one"></span>
              <span class="role">Physiologist</span>
            </label>
            <label for="dot-2">
              <span class="dot two"></span>
              <span class="role">Inquirer</span>
            </label>
          </div>
		    <span id="roleErrorMessage" style="display: none; color: red;">Please choose a role.</span>
        </div>
        <div class="button">
          <input type="submit" value="Register">
        </div>
		<p style="text-align: center;">Already Got An Account? Click <a href="login.php">Here</a> to Log-in</p>
		<p style="text-align: center;">Click<a href="loginPatient.php">Here</a> to Log-in As A Patient</p>
      </form>
    </div>
  </div>
</div>


<script>
    document.getElementById("password").addEventListener("input", function() {
        var password = this.value;
        var capitalLetterRegex = /[A-Z]/;
        var numberRegex = /[0-9]/;
        var isValidPassword = password.length >= 8 && capitalLetterRegex.test(password) && numberRegex.test(password);
        var passwordErrorMessage = document.getElementById("passwordErrorMessage");
        if (!isValidPassword) {
            passwordErrorMessage.style.display = "block";
        } else {
            passwordErrorMessage.style.display = "none";
        }
    });
</script>




<footer class="container-fluid text-center">
  <a href="#home" title="To Top">
    <span class="glyphicon glyphicon-chevron-up" style="color: purple;" ></span>
  </a>
  <p>&copy; Copyright 2024 King Saud University</p>
</footer>


</body>
</html>
