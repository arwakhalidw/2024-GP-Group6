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
    $password = "";
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
    echo '<script>alert("Email is already registered"); window.location.href = "index.php";</script>';
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
</head>


<body id="home" data-spy="scroll" data-target=".navbar" data-offset="60">

    <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #490665;">
  <div class="container">
    <div class="navbar-header" >  
      <a class="navbar-brand" href="index.php">
        <img src="img/logo.png" alt="logo">
      </a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
  
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#about">ABOUT</a></li>
        <li><a href="#mission">MISSION</a></li>
        <li><a href="checkRoleRegister.php">JOIN TODAY</a></li>
        <li><a href="checkRole.php">SIGN-IN</a></li>
      </ul>
    </div>
  </div>
</nav>


<div class="jumbotron text-center">
  <h1>Alzheimer's Predictor</h1> 
  <p>Streamlining Alzheimer's Prediction: Just a Few Clicks Away</p> 
 
    <div class="input-group">
      <div class="input-group-btn">
     <nav class="navbar navbar-default"><a href="checkRoleRegister.php" class="btn btn-primary" style="color: white; background-color: #3d1b4a; opacity:0.8; text-decoration: none; border-style: none;">Join</a></nav>

      </div>
    </div>
 
</div>

<!-- Container (About Section) -->
<div id="about" class="container-fluid">
  <div class="row">
    <div class="col-sm-8">
      <h2>About Us</h2><br>
      <h4>Welcome to our revolutionary application dedicated to predicting Alzheimer's disease using cutting-edge machine learning technology.</h4><br>
      <p>Our machine learning algorithms analyze various factors, including user input, behavioral patterns, and medical history, to predict the likelihood of developing Alzheimer's disease. By leveraging vast amounts of data, our system can identify subtle changes indicative of cognitive decline, enabling early intervention and personalized treatment plans.</p>
      <br>
    </div>
    <div class="col-sm-4">
      <span class="logo slideanim"><img width="200" height="200" src="https://parspng.com/wp-content/uploads/2023/10/brainpng.parspng.com-7.png"></span>
    </div>
  </div>
</div>


<!-- Container (Mission Section) -->
<div id="mission" class="container-fluid text-center">
  <h2>MISSION</h2>
 <div class="container-fluid bg">
  <div class="row">
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-globe logo slideanim black"></span>
    </div>
    <div class="col-sm-8">
      <h2>Our Mission Is Simple...</h2><br>
      <h4>to empower individuals with the knowledge and resources necessary to take proactive steps towards managing their cognitive health. Alzheimer's disease is a progressive neurodegenerative disorder that affects millions of people worldwide, often with devastating consequences for both patients and their loved ones. Early detection is crucial for effective management and intervention, which is why we have developed a comprehensive platform that combines the power of machine learning with the accessibility of a chatbot interface.</h4><br>
      
    </div>
  </div>
</div>
</div>



<footer class="container-fluid text-center">
  <a href="#home" title="To Top">
    <span class="glyphicon glyphicon-chevron-up" style="color: purple;" ></span>
  </a>
  <p>&copy; Copyright 2024 King Saud University</p>
</footer>


</body>
</html>
