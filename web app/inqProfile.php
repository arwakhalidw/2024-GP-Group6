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
                    <li><a href="#profile">PROFILE</a></li>
                    <li><a href="#dia">DiA Diagonistic Tool</a></li>
                    <li><a href="logout.php">LOG-OUT</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="jumbotron text-center">

        <?php
        session_start();
        $email = $_SESSION['email'];
        $servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ADPrediction";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Could not connect to the database");
}
        $query = "SELECT * FROM Inquirer WHERE email='$email'";
        $result= mysqli_query($conn,$query);
        while ($row = mysqli_fetch_assoc($result)) {
        echo" <h1>Welcome back, ".$row['name']."!</h1><br><br>";
        }
        ?>


        <div class="input-group">
            <div class="input-group-btn">
                <nav class="navbar navbar-default"><a href="#profile" class="btn btn-primary"
                        style="color: white; background-color: #3d1b4a; opacity:0.8; text-decoration: none; border-style: none;">Profile</a>
                </nav>
                <nav class="navbar navbar-default"><a href="#dia" class="btn btn-primary"
                        style="color: white; background-color: #3d1b4a; opacity:0.8; text-decoration: none; border-style: none;">Alzheimer's
                        Prediction</a></nav>
            </div>
        </div>
    </div>

    <!-- Container (Profile Section) -->
    <div id="profile" class="container-fluid">
        <h2 class="text-center">USER PROFILE</h2>
        <div class="container-signup">
            <div class="title">User Profile</div>
            <div class="content">
                <form id="profileForm" action="#" method="POST">
                    <div class="user-details">
                        <?php
                           
                    
                            // Query user details
                            $query = "SELECT * FROM inquirer WHERE email='$email'";
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
                                        <input type="text" name="role" placeholder="Your role" value="Inquirer" disabled>
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

</body>

</html>