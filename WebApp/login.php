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

        $conn = new mysqli($servername, $username, $password, $dbname);

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
                if (password_verify($pass, $row['password'])) {
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
                if (password_verify($pass, $row['password'])) {
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
  <!-- Theme Made By www.w3schools.com -->
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
        <img src="images/logo.png" alt="logo">
      </a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
 <li><a href="index.php#about">ABOUT</a></li>
 <li><a href="index.php#mission">MISSION</a></li>
        <li><a href="index.php#register">JOIN TODAY</a></li>
		<li><a href="login.php">SIGN-IN</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>Sign-in</h1> 
  <div class="input-group">
    <div class="input-group-btn">
      <ul class="list-unstyled" style="padding-left: 0;">
        <li style="margin-bottom: 10px;"><a href="#inq" class="btn btn-primary" style="color: white; background-color: #3d1b4a; opacity:0.8; text-decoration: none; border-style: none; font-family: 'Lato', sans-serif;" onclick="scrollToSection('#inq')">Sign-in As An Inquirer</a></li>
        <li><a href="#physio" class="btn btn-primary" style="color: white; background-color: #3d1b4a; opacity:0.8; text-decoration: none; border-style: none; font-family: 'Lato', sans-serif;" onclick="scrollToSection('#physio')">Sign-in As A Physiologist</a></li>
      </ul>
    </div>
  </div>
</div>

<script>
function scrollToSection(sectionId) {
  $('html, body').animate({
    scrollTop: $(sectionId).offset().top
  }, 1000);
}
</script>




<!-- Container (Inquirer Login Section) -->
<div id="inq" class="container-fluid">
   <div class="wrapper">
         <div class="title">
            Inquirer Login
         </div>
         <form method="post">
            <div class="field">
               <input type="email" name="email" required>
               <label>Email Address</label>
            </div>
            <div class="field">
               <input type="password" name="password" required>
               <label>Password</label>
            </div>
           
            <div class="field">
			<input type="hidden" name="role" value="inquirer">
               <input type="submit" value="Login">
            </div>
            <div class="signup-link">
               Not a member? <a href="index.php#register">Signup</a><br>
			   Or Sign Up As A <a href="#physio" class="btn-scroll">Physiologist</a>
            </div>
         </form>
      </div>
</div>




<!-- Container (Physiologist Login Section) -->
<div id="physio" class="container-fluid">
   <div class="wrapper">
         <div class="title">
            Physiologist Login
         </div>
         <form method="post">
            <div class="field">
               <input type="email" name="email" required>
               <label>Email Address</label>
            </div>
            <div class="field">
               <input type="password" name="password" required>
               <label>Password</label>
            </div>
           
            <div class="field">
			 <input type="hidden" name="role" value="physiologist">
               <input type="submit" value="Login">
            </div>
            <div class="signup-link">
                Not a member? <a href="index.php#register">Signup</a><br>
			   Or Sign Up As An <a href="#inq" class="btn-scroll">Inquirer</a>
            </div>
         </form>
      </div>
</div>

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