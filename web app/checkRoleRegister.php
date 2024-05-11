<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Sign Up</title>
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
            .category{
                flex-direction: column;
                padding-left: 30%;
            }

            .wrapper form{
                margin-top: -10%;
            }

            .container-fluid{
                padding-top: 15%;
            }
        </style>
        <script>
            function checkRole(event) {
                event.preventDefault(); // Prevent the form from being submitted

                var role = document.querySelector('input[name="role"]:checked');

                if (!role) {
                    document.getElementById("roleErrorMessage").style.display = "block";
                    return false;
                } else {
                    document.getElementById("roleErrorMessage").style.display = "none";
                    var roleValue = role.value;
                    if (roleValue === "physinq") {
                        window.location.href = "registerPhysAndInq.php";
                    } else if (roleValue === "patient") {
                        window.location.href = "loginPatient.php";
                    }
                    return true;
                }
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


        <!-- Container -->
        <div id="checkRole" class="container-fluid">
            <div class="wrapper">
                <h2 class="text-center" style="padding-top: 12%">
                    Sign-up As
                </h2>
                <form method="post" onsubmit="return checkRole(event);">
                    <div class="role-details">
                        <input type="radio" name="role" value="physinq" id="dot-1">
                        <input type="radio" name="role" value="patient" id="dot-3">
                        <br>
                        <div class="category">
                            <label for="dot-1">
                                <span class="dot one"></span>
                                <span class="role">Physiologist/Inquirer</span>
                            </label>
                            <label for="dot-3">
                                <span class="dot three"></span>
                                <span class="role">Patient</span>
                            </label>
                            <br>
                        </div>
                        <span id="roleErrorMessage" style="display: none; color: red;">Please choose a role.</span>
                    </div>
                    
                    <div class="field">
                        <input type="submit" value="Enter">
                    </div>
                </form>
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
