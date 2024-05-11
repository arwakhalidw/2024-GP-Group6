<?php
session_start();

// Check if the user is logged in and their role is physiologist
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'physiologist') {
    echo '<script>alert("You are not authorized to access this page."); window.location.href = "index.php";</script>';
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["dataset"]["name"]);
    move_uploaded_file($_FILES["dataset"]["tmp_name"], $target_file);
	
    // Get the full path to the uploaded file
    $uploaded_file = realpath($target_file);

    // Get other form data
    $Fmethod = $_POST["Fmethod"];
    $classifier = $_POST["classifier"];
    $type = $_POST["approach"];
    $folds = $_POST["folds"];

    // Construct the full path to the Python script
    $script_path = __DIR__ . "/script.py";

    // Call Python script
    $command = escapeshellcmd("python $script_path $uploaded_file \"$Fmethod\" \"$classifier\" \"$type\" \"$folds\"");
    $output = shell_exec($command);
	
	// Extract accuracy and selected features from the output
	list($accuracy, $selected) = explode("\n", trim($output));
}

?>
<!DOCTYPE html>
<html lang="en">
<!-- Theme Made By www.w3schools.com -->
<!-- Cards By CodingLab -->
<head>
<title>Result</title>
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

<script>

        // JavaScript function to navigate back
    function goBack() {
      window.history.back();
    }
	
	
	
</script>
<style>
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
            <div class="container-fluid">
            <div class="container-signup">
                <div class="user-details">
                    <div class="title">Results</div>
					<div class="content">
                    <form id="modelForm" action="#">
					<div class="user-details">
                    <div class="input-box">
                        <span class="details">Feature Selection Method:</span>
                        <input type="text" name="method" value="<?php echo "$Fmethod";?>" disabled>
                    </div>
					<div class="input-box">
                        <span class="details">Classifier:</span>
                        <input type="text" name="classifier" value="<?php echo "$classifier"; ?>" disabled>
                    </div>
					<div class="input-box">
                        <span class="details">Approach: </span>
                        <input type="text" name="approach" value="<?php echo "$type"; ?>" disabled>
                    </div>
					
                    <div class="input-box">
                        <span class="details">Accuracy</span>
                        <input type="text" name="accuracy" value="<?php echo "$accuracy"; ?>" disabled>
                    </div>
					<div class="input-box">
                        <span class="details">Selected Features: </span>
                        <textarea rows="3" cols="20" name="selectedFeatures" disabled><?php echo "$selected"; ?></textarea>
                    </div>
					</form>
					</div>
					<a class="previous" onclick="goBack()">&laquo; Previous</a>
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

