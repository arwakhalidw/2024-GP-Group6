<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

        <style>
            .smallcont{
                padding-left: 9%;
            }
        </style>
		<script>
    $(document).ready(function() {
        $('input[name=nid]').on('change', function() {
            var nid = $(this).val(); // Get the National ID entered by the physiologist
            // AJAX request to fetch patient's name
            $.ajax({
                type: 'POST',
                url: 'get_patient_name.php',
                data: {nid: nid},
                success: function(response) {
                    $('input[name=name]').val(response); // Update the patient's name field
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error occurred while fetching patient\'s name.');
                }
            });
        });
    });
</script>


        <link rel="stylesheet" href="HP.css" type="text/css">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>

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

                <!-- Container (model Section) -->
                <div id="model" class="container-fluid">
                    <h2 class="text-center">DiA</h2>
                    <div class="container-signup">
                        <div class="title">Alzhiemer Prediction</div>
                        <div class="content">
                            <form id="modelForm" action="result.php" method="POST" onsubmit="return validateForm();">
                                <div class="user-details">
                                    <div class="input-box">
                                        <span class="details">Patient's ID</span>
										<input type="text" name="nid" placeholder="Enter patient's ID" maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57" pattern="^[0-9]*$" required>
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Patient's Name</span>
                                        <input type="text" name="name" value="" readonly>
                                    </div>
                                    <div class="input-box">
                                        <span class="details">CDR score</span>
										<input type="number" name="cdr" placeholder="Enter patient's CDR" required step="0.5" min="0" max="3" pattern="\d+(\.\d+)?">
                                    </div>
                                    <div class="input-box">
                                        <span class="number">MMSE score</span>
                                        <input type="number" name="mmse" placeholder="Enter patinet's score" min="0" max="30" required>
                                    </div>
                                    <div class="input-box">
                                        <span class="details">nWBV</span>
                                        <input type="number" name="nWBV" id="nWBV" placeholder="Enter patient's nWBV" required step="0.01">
                                    </div>
                                    <div class="input-box">
                                        <span class="details">Years of Education</span>
                                        <input type="number" id="educ" name="educ" placeholder="Enter patient's years of education"
                                               required>
                                    </div>
                                    <div class="role-details">
                                        <input type="radio" name="gender" value="Male" id="dot-1">
                                        <input type="radio" name="gender" value="Female" id="dot-2">

                                        <div class="category">
                                            <label for="dot-1">
                                                <span class="dot one"></span>
                                                <span class="role">Male</span>
                                            </label>
                                            <label for="dot-2">
                                                <span class="dot two"></span>
                                                <span class="role">Female</span>
                                            </label>
                                        </div>
                                        <span id="genderErrorMessage" style="display: none; color: red;">Please choose a gender.</span>
                                    </div>
<script>
    function validateForm() {
        var gender = document.getElementsByName('gender');
        var genderErrorMessage = document.getElementById('genderErrorMessage');

        // Check if either radio button is checked
        var isChecked = false;
        for (var i = 0; i < gender.length; i++) {
            if (gender[i].checked) {
                isChecked = true;
                break;
            }
        }

        // Display error message if no radio button is checked
        if (!isChecked) {
            genderErrorMessage.style.display = 'block';
            return false;
        } else {
            genderErrorMessage.style.display = 'none';
            return true;
        }
    }
</script>
                                </div>
                                <div class="button">
                                    <input type="submit" value="Predict">
                                </div>

                            </form>
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

