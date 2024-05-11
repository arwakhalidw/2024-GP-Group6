<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <title>Dashboard</title>
        <link rel="stylesheet" href="physDash.css" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link href="index.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="script.js"></script>
        <link rel="stylesheet" href="HP.css" type="text/css">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    </head>
<style>
        .smallcont{
            padding-left: 9%;
            padding-right: 9%;
            padding-bottom: 9%;
        }
        
          .sidebar{
            padding-right: 10%;
        }
        
        .sidebar ul li{
            padding: 27.5%;
        }
        
        #first{
            padding-top: 15%;
        }
    </style>
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
                    <li id="first" class="fas fa-user"><a href="physProfile.php">profile</a></li>
                    <li class="fas fa-chart-bar"><a href="physDashboard.php">Dashboard</a></li>
                    <li class="fas fa-chart-bar"><a href="model.php">DiA</a></li>
                    <li class="fas fa-align-center"><a href="test.php">Models</a></li>
                    <li class="fas fa-question-circle"><a>Help</a></li>
                </ul>
            </div>

            <section class="main">

                <div class="smallcont">
                    <section class="attendance">
                        <div class="attendance-list">
                            <h1>My Patients</h1>
                            <a href="Addpatient.php">+ Add Patient</a>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Date of Birth</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    session_start();
// Database connection
									// Check if the user is logged in and their role is physiologist
									if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'physiologist') {
										echo '<script>alert("You are not authorized to access this page."); window.location.href = "index.php";</script>';
										exit; 
									}
                                    $servername = "localhost";
                                    $username = "root";
                                    $password = "root";
                                    $dbname = "adprediction";

// Create connection
                                    $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    if (isset($_SESSION['email'])) {
                                        $er = $_SESSION['email'];
                                        $e = "SELECT physiologistId FROM physiologist where email='$er'";
                                        $p = $conn->query($e);
                                        if ($p->num_rows > 0) {
                                            $ro = $p->fetch_assoc(); // Fetch the row from the result
                                            $phys = $ro['physiologistId']; // Get the value of 'physiologistId' column
                                            $sql = "SELECT * FROM patient where physiologist='$phys'";
                                            $result = $conn->query($sql);

// Display patient data in a table
                                            if ($result->num_rows > 0) {

                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row["PatientID"] . "</td>";
                                                    echo "<td>" . $row["FirstName"] . " " . $row["LastName"] . "</td>";
                                                    echo "<td>" . $row["DOB"] . "</td>";
                                                    echo"<td><button>View</button></td>";
                                                    echo "</tr>";
                                                }

                                            } else {
                                                 echo "<tr>";
                                                  echo "<td colspan='4' style='text-align:center;'>";
                                                echo "You haven't added any patients";
                                                 echo "</td>";
                                                 echo "</tr>";
                                             
                                            }
                                        }
                                    }
// Close connection
                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
            </section>

        </div>



        <footer class="container-fluid text-center">
            <a href="#home" title="To Top">
                <span class="glyphicon glyphicon-chevron-up" style="color: purple;"></span>
            </a>
            <p>&copy; Copyright 2024 King Saud University</p>
        </footer>
                
    </body>

</html>
