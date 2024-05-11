<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
        <style>
            .wrapper form{
                margin-top: -10%;
            }

            .container-fluid{
                padding-top: 15%;
            }
        </style>
        <script>
            function OTP(){
                document.getElementById("otp").style.display = "block";
            }
        </script>
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

        <script>
            function scrollToSection(sectionId) {
                $('html, body').animate({
                    scrollTop: $(sectionId).offset().top
                }, 1000);
            }
        </script>



        <!-- Container -->
        <div id="loginPatient" class="container-fluid">
            <div class="wrapper">

                <div class="title">
            Login As Patient
         </div> <br><br>
                <form method="post">
                    <div class="field">
                        <input type="text" name="nid" pattern="[0-9]{10}" required>
                        <label>ID</label>
                    </div>
                    <div class="field">
                        <input type="tel" name="pno" pattern="[0-9]{3}[0-9]{3}[0-9]{4}"  required>
                        <label>Phone Number</label>
                    </div>
                    <div class="field" id="otp" style="display:none;">
                        <input type="text" name="otp" pattern="[0-9]{4}" required>
                        <label>Enter 4-digit OTP number</label>
                    </div>
                    <br>
                    <div class="field">
                        <input type="submit" value="Enter" onclick="OTP();">
                    </div>
					<div class="signup-link">
               Click <a href="login.php">Here</a> To Sign-in As A Physiologist or Inquirer<br>
            </div>
                </form>
            </div>
        </div>
        

        <script>
            $(document).ready(function () {


                // Smooth scrolling for buttons
                $(".btn-scroll").on('click', function (event) {
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