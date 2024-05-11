<?php
session_start();

// Check if the user is logged in and their role is physiologist
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'physiologist') {
    echo '<script>alert("You are not authorized to access this page."); window.location.href = "index.php";</script>';
    exit;
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Try our model</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link href="sign-up.css" rel="stylesheet" type="text/css">
    <link href="index.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<script>
    $(document).ready(function() {
        // Initially hide the crossfold select
        $('#cross').hide();

        // Listen for changes in the radio button selection
        $('input[name="approach"]').change(function() {
            // If "k-fold Cross Validation" radio button is selected, show the crossfold select
            if ($(this).val() === 'k-fold Cross Validation') {
                $('#cross').show();
            } else {
                // Otherwise, hide the crossfold select
                $('#cross').hide();
            }
        });
    });
</script>
    <script>
    function validateForm() {
        var featureMethod = document.forms["testingForm"]["Fmethod"].value;
        var classifier = document.forms["testingForm"]["classifier"].value;
        var dataset = document.forms["testingForm"]["dataset"].value;

        // Perform validation checks
        if (featureMethod.trim() === "") {
            alert("Please select a feature selection method.");
            return false;
        }
        if (classifier.trim() === "") {
            alert("Please select a classifier type.");
            return false;
        }
        if (dataset.trim() === "") {
            alert("Please upload a dataset.");
            return false;
        }


        // If all checks pass, the form is valid
        return true;
    }
</script>
    <link rel="stylesheet" href="HP.css" type="text/css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <style>
        .smallcont{
            padding-left: 9%;
        }
    </style>
</head>

<body>

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
    <!-- Container (test Section) -->
    <div id="test" class="container-fluid">
        <h2 class="text-center">DiA</h2>
        <div class="container-signup">
            <div class="title">Test our models</div>
            <div class="content">
                <form id="testingForm" action="testResult.php" method="POST" onsubmit="return validateForm();" enctype="multipart/form-data">
                    <div class="user-details">
                        <div class="input-box">
                            <label for="method" class="details">Feature Selection Method</label>
                            <select name="Fmethod" id="method" required>
                                <option value="None">None</option>
                                <option value="mRMR">Minumum Redundancy Maximum Relevance (mRMR)</option>
								<option value="Correlation Coeffecient">Correlation Coeffecient</option>
                                <option value="Mutual Information">Mutual Information</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <label for="classifier" class="details">Classifier Type</label>
                            <select name="classifier" id="classifier" required>
                                <option value="Support Vectors">Support Vectors</option>
                                <option value="Random Forest">Random Forest</option>
                                <option value="Logistic Regression">Logistic Regression</option>
                            </select>
                        </div>
                        <div class="role-details">
                            <input type="radio" name="approach" value="k-fold Cross Validation" id="dot-1" required>
                            <input type="radio" name="approach" value="Holdout" id="dot-2" checked required>
                            <div class="category">
                                <label for="dot-1">
                                    <span class="dot one"></span>
                                    <span class="role">K-folds</span>
                                </label>
                                <label for="dot-2">
                                    <span class="dot two"></span>
                                    <span class="role">Holdout (70/30)</span>
                                </label>
                            </div>
                        </div>
                        <div class="input-box" id="cross">
                            <label for="folds" class="details">Cross fold</label>
                            <select name="folds" id="folds" required>
                                <option value="k=5">k=5</option>
                                <option value="k=10">k=10</option>
                                <option value="Leave One Out Cross-Validation">Leave One Out Cross-Validation</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <label for="dataset" class="details">Upload Dataset</label>
                            <input type="file" id="dataset" name="dataset" required>
                        </div>
                    </div>
                    <div class="button">
                        <input type="submit" value="Try">
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