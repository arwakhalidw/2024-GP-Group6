
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
                <a class="navbar-brand" href="patientHP.php">
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
                <li class="fas fa-user"><a href="patientProfile.php">profile</a></li>
                <li class="fas fa-chart-bar"><a href="patientDashboard.php">Dashboard</a></li>
                <li class="fas fa-question-circle"><a>Help</a></li>
            </ul>
        </div>

        <div class="smallcont">

            <div class="subground">
                <div class="subground">
                    <div class="intro">
                        <h1>Welcome to DiA</h1>
                    </div>
                </div>
            </div>


            <div id="services" class="container-fluid bg">
                <h2 class="text-center">Features</h2>
                <div class="container-ser">
                    <div class="box">
                        <div class="image">
                            <img src="patient.png">
                        </div>
                        <div class="service-name">View history</div>

                        <p>with DiA you can View your profile and prediction history. </p>

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