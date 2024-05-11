<?php 
session_start();
// Check if the user is logged in and their role is physiologist
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'physiologist') {
    echo '<script>alert("You are not authorized to access this page."); window.location.href = "index.php";</script>';
    exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Convert gender to numerical value
    $gender = ($_POST['gender'] == 'Male') ? 0 : 1;

    // Get input data from the form
    $data = array(
        'gender' => $gender,
        'educ' => $_POST['educ'],
        'mmse' => $_POST['mmse'],
        'nwbv' => $_POST['nWBV'],
		'cdr' => $_POST['cdr']
    );

    // Prepare data to send to Python API
    $payload = json_encode($data);

    // Python API URL
    $url = 'http://127.0.0.1:5000/predict';

    // Set additional options for the HTTP request
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => $payload
        )
    );

    $context  = stream_context_create($options);

    // Make the HTTP request to Python API
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        echo "Error accessing Python API";
    } else {
        // Decode JSON response
        $prediction = json_decode($result, true);
         // Interpret the prediction
        $diagnosis = ($prediction['prediction'][0] == 1) ? "Alzheimer's" : "No Alzheimer's";
		
		

    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Theme Made By www.w3schools.com -->
    <!-- Cards By CodingLab -->
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

    <style>
        .button{
            height: 45px;
            margin: 35px 0
        }
        .button input{
            height: 100%;
            width: 100%;
            border-radius: 5px;
            border: none;
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
        }
        .button input:hover{
            /* transform: scale(0.99); */
            background: linear-gradient(-135deg, #71b7e6, #9b59b6);
        }

        .smallcont{
            padding-top: 10%;
            padding-left: 17%;
            padding-bottom: 17%;
        }

        .smallcont h1, h4{
            text-align: center;
            padding: 3%;
        }

        .result{
            padding-top: 20%;
        }
		
		a {
	  text-decoration: none;
	  display: inline-block;
	  padding: 8px 16px;
	}

	a:hover {
	  background-color: #ddd;
	  color: black;
	}

	.previous {
	  background-color: #f1f1f1;
	  color: black;
	}

	.smallcont{
				padding-left: 9%;
			}
    </style>
	<script>

        // JavaScript function to navigate back
    function goBack() {
      window.history.back();
    }
	
	
	
</script>

</head>

<body id="home" data-spy="scroll" data-target=".navbar" data-offset="60">

    <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #490665;">
        <div class="container">
            <div class="navbar-header">
                <!-- Brand/logo -->
                <a class="navbar-brand" href="physHP.php">
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
                    <li class="fas fa-user"><a href="physProfile.php">profile</a></li>
                    <li class="fas fa-chart-bar"><a href="physDashboard.php">Dashboard</a></li>
                    <li class="fas fa-chart-bar"><a href="model.php">DiA</a></li>
                    <li class="fas fa-align-center"><a href="test.php">Models</a></li>
                    <li class="fas fa-question-circle"><a>Help</a></li>
                </ul>
            </div>

        <div class="smallcont">
            <div class="result">
                <h1>Result</h1>
				 <div class="user-details">
				 <div class="input-box">
                                        <span class="details">Patient's Name</span>
				 <input type="text" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" readonly>
						
                 </div>
				  <div class="input-box">
                                        <span class="details">CDR</span>
				 <input type="text" name="name" value="<?php echo isset($_POST['cdr']) ? htmlspecialchars($_POST['cdr']) : ''; ?>" readonly>
						
                 </div>
				  <div class="input-box">
                                        <span class="details">MMSE</span>
				 <input type="text" name="name" value="<?php echo isset($_POST['mmse']) ? htmlspecialchars($_POST['mmse']) : ''; ?>" readonly>
						
                 </div>
				  <div class="input-box">
                                        <span class="details">nWBV</span>
				 <input type="text" name="name" value="<?php echo isset($_POST['nWBV']) ? htmlspecialchars($_POST['nWBV']) : ''; ?>" readonly>
						
                 </div>
				  <div class="input-box">
                                        <span class="details">Years of Education</span>
				 <input type="text" name="name" value="<?php echo isset($_POST['educ']) ? htmlspecialchars($_POST['educ']) : ''; ?>" readonly>
						
                 </div>
				  <div class="input-box">
                                        <span class="details">Gender</span>
				 <input type="text" name="name" value="<?php echo isset($_POST['gender']) ? htmlspecialchars($_POST['gender']) : ''; ?>" readonly>
						
                 </div>
                              <?php
							  echo "<h4>Patient likely has <b>$diagnosis</b></h4>"; 
							  ?>

                <div class="button"><input type="submit" value="Show History"></div>
				<a class="previous" onclick="goBack()">&laquo; Previous</a>
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