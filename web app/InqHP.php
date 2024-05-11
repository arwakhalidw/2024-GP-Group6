<?php
session_start();

// Check if the user is logged in and their role is inquirer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'inquirer') {
	echo '<script>alert("You are not authorized to access this page."); window.location.href = "index.php";</script>';
    exit; 
}

// Proceed with displaying the profile page for inquirer
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ADPrediction";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Could not connect to the database");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <title>Homepage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link href="sign-up.css" rel="stylesheet" type="text/css">
  <link href="index.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="script.js"></script>
  <link rel="stylesheet" href="HP.css" type="text/css">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>

</head>


<body id="home" data-spy="scroll" data-target=".navbar" data-offset="60">

  <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #490665;">
    <div class="container">
      <div class="navbar-header">
        <!-- Brand/logo -->
        <a class="navbar-brand" href="InqHP.php">
          <img src="img/logo.png" alt="logo">
        </a>

      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <!-- Links -->
        <ul class="nav navbar-nav navbar-right">
          <li><a href="logout.php">LOG-OUT</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="bigcont">
    <div class="sidebar">
      <ul>
          <li class="fas fa-user"><a href="inqProfile.php">profile</a></li>
        <li class="fas fa-chart-bar"><a>Dashboard</a></li>
        <li class="fas fa-question-circle"><a>Help</a></li>
      </ul>
    </div>

    <div class="smallcont">
      <!-- dia intro -->

      <div class="subground">
        <div class="subground">
          <div class="intro">
            <h1>Hello, I am Dia diagnosis system. I can help you assess your condition <br> regarding Alzheimer's disease.</h1>
          </div>

          <br>

          <nav class='intro' class="navbar navbar-default"><a href="#" class="btn btn-primary"
              style="color:aliceblue; text-decoration: none; border: transparent; background-color: #540075;"><b>Chat with
                DiA</b></a></nav>
        </div>
      </div>



      <!-- Container (Dia Section) -->

      <div id="dia" class="container-fluid text-center">

        <h2 class="text-center">About DiA</h2>

        <div class="container bg">
          <div class="row">
            <div class="col-sm-4">
              <span><img width="70%" height="70%" src="img/people.jpg" style="border-radius: 80px 20px 50px 20px;"></span>
            </div>
            <div class="col-sm-8">
              <h2>A Diagonistic Tool</h2><br>
              <h4> DiA is an interactive chatbot that administers diagnostic scales such as CDR. and other diagnostic
                tests
                .
                DiA guides you through these tests, analyzes your responses,
                and provides comprehensive reports, aiding in the identification of cognitive impairments and memory
                disorders.</h4><br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>





  <footer class="container-fluid text-center">
    <a href="#home" title="To Top">
      <span class="glyphicon glyphicon-chevron-up" style="color: purple;"></span>
    </a>
    <p>&copy; Copyright 2024 King Saud University</p>
  </footer>


</body>

</html>