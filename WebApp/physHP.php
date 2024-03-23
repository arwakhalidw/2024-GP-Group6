<?php
session_start();

// Check if the user is logged in and their role is physiologist
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'physiologist') {
    echo '<script>alert("You are not authorized to access this page."); window.location.href = "index.php";</script>';
    exit; 
}

// Proceed with displaying the profile page for physiologists
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
  <!-- Theme Made By www.w3schools.com -->
  <!-- Cards By CodingLab -->
  <title>Homepage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
   <link href="sign-up.css" rel="stylesheet" type="text/css">
   <link href="index.css" rel="stylesheet" type="text/css"> 
   <link href="HP.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="script.js"></script>
  
   
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
	
	
 
</head>
<body id="home" data-spy="scroll" data-target=".navbar" data-offset="60">

   <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #490665;">
  <div class="container">
    <div class="navbar-header">
      <!-- Brand/logo -->
      <a class="navbar-brand" href="physHP.php">
        <img src="images/logo.png" alt="logo">
      </a>
     
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <!-- Links -->
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#profile">PROFILE</a></li>
        <li><a href="#services">SERVICES</a></li>
        <li><a href="logout.php">LOG-OUT</a></li>
      </ul>
    </div>
  </div>
</nav>


<div class="jumbotron text-center">

<?php
$email = $_SESSION['email'];
$query = "SELECT * FROM Physiologist WHERE email='$email'";
$result= mysqli_query($conn,$query);
while ($row = mysqli_fetch_assoc($result)) {
echo" <h1>Welcome back, ".$row['name']."!</h1><br><br>";
}
 ?>

  
 <div class="input-group">
      <div class="input-group-btn">
     <nav class="navbar navbar-default"><a href="#profile" class="btn btn-primary" style="color: white; background-color: #3d1b4a; opacity:0.8; text-decoration: none; border-style: none;">Profile</a></nav>
 <nav class="navbar navbar-default"><a href="#services" class="btn btn-primary" style="color: white; background-color: #3d1b4a; opacity:0.8; text-decoration: none; border-style: none;;">Services</a></nav>
      </div>
    </div>
  </div>
  
<!-- Container (Profile Section) -->
<div id="profile" class="container-fluid">
    <h2 class="text-center">MY PROFILE</h2>
    <div class="container-signup">
	 <div class="title">Physiologist's Profile</div>
        <div class="content">
            <form id="profileForm" action="#" method="POST">
                <div class="user-details">
                    <?php
                   
			
                    
                    $query = "SELECT * FROM Physiologist WHERE email='$email'";
                    $result = mysqli_query($conn, $query);

                    // Display user details
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="input-box">
                                <span class="details">Full Name</span>
                                <input type="text" name="fullName" value="' . $row['name'] . '" disabled>
                              </div>';
                        echo '<div class="input-box">
                                <span class="details">Email</span>
                                <input type="email" name="email" placeholder="Enter your email" value="' . $row['email'] . '" disabled>
                              </div>';
                        echo '<div class="input-box">
                                <span class="details">Password</span>
                                <input type="password" name="password" placeholder="Enter your password" value="********" disabled>
                              </div>';
                        echo '<div class="input-box">
                                <span class="details">Role</span>
                                <input type="text" name="role" placeholder="Your role" value="Physiologist" disabled>
                              </div>';
                    }
                    ?>
                </div>
                <div class="button">
               <input type="submit" class="update-button" value="Update">
            </div>
            </form>
        </div>
    </div>
</div>




<!-- Container (Services Section) -->
<div id="services" class="container-fluid bg">
  <h2 class="text-center">Services</h2>
  <div class="container-ser">
      <div class="box">
      <div class="image">
          <img src="images/patient.png">
        </div>
        <div class="service-name">View Patients</div>
       
        <p>View your patients' profiles and predictions history. </p>
        <div class="btns">
       
          <button>View Patients</button>
        </div>
      </div>
      <div class="box">
        <div class="image">
          <img src="images/machine.png" alt="">
        </div>
        <div class="service-name">Predict Dementia</div>
      
        <p>Use our machine learning model to predict Alzheimer's.</p>
        <div class="btns">
         
          <button>Predict Dementia</button>
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


    