 <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = strtolower($_POST['email']);
        $pass = $_POST['password'];
        $role = $_POST['role'];

        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "ADPrediction";

        $conn = new mysqli($servername, $username,$password, $dbname);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

    
		
        // Validate login based on the role
    if ($role == 'inquirer') {
    // Validate login for inquirer
    $sql_inquirer = "SELECT * FROM inquirer WHERE email='$email'";
    $result_inquirer = mysqli_query($conn, $sql_inquirer);

    if (mysqli_num_rows($result_inquirer) == 1) {
        $row = mysqli_fetch_assoc($result_inquirer);
        // Verify the hashed password with the plain-text password provided by the user
        if ($pass === $row['password']) {
            $_SESSION['role'] = 'inquirer';
            $_SESSION['email'] = $email;
            header("location: inqHP.php");
            exit;
        }
    }
} elseif ($role == 'physiologist') {
    // Validate login for physiologist
    $sql_physiologist = "SELECT * FROM physiologist WHERE email='$email'";
    $result_physiologist = mysqli_query($conn, $sql_physiologist);

    if (mysqli_num_rows($result_physiologist) == 1) {
        $row = mysqli_fetch_assoc($result_physiologist);
        // Verify the hashed password with the plain-text password provided by the user
        if ($pass === $row['password']) {
            $_SESSION['role'] = 'physiologist';
            $_SESSION['email'] = $email;
            header("location: physHP.php");
            exit;
        }
    }
}

        echo '<script>alert("Incorrect Email or Password");</script>';
        mysqli_close($conn);
    }
?>

	
<!DOCTYPE html>
<html lang="en">
<head>
 
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link href="login.css" rel="stylesheet" type="text/css">
  <link href="index.css" rel="stylesheet" type="text/css">
  <link href="sign-up.css" rel="stylesheet" type="text/css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
  
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




<!-- Container -->
<div id="inq" class="container-fluid">
   <div class="wrapper">
         <div class="title">
            Login
         </div>
         <form method="post" onsubmit="return validateForm();">
            <div class="field">
               <input type="email" name="email" required>
               <label>Email Address</label>
            </div>
            <div class="field">
               <input type="password" name="password" required>
               <label>Password</label>
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
            <div class="field">
               <input type="submit" value="Enter">
            </div>
            <div class="signup-link">
               Not a member? <a href="registerPhysAndInq.php">Sign up</a><br>
			   Are you a Patient? Click <a href="loginPatient.php">Here</a><br>
            </div>
         </form>
      </div>
</div>
<script>
    function validateForm() {
        // Get the selected role
        var role = document.querySelector('input[name="role"]:checked');

        // Check if a role is selected
        if (!role) {
            // Show the roleErrorMessage
            document.getElementById("roleErrorMessage").style.display = "block";
            // Prevent form submission
            event.preventDefault();
        }
    }
</script>


<script>
$(document).ready(function(){
  

  // Smooth scrolling for buttons
  $(".btn-scroll").on('click', function(event) {
    scrollToSection(this.hash);
  });

  // Function to smoothly scroll to a section
  function scrollToSection(hash) {
    if (hash !== "") {
      event.preventDefault();
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 1000);
    }
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