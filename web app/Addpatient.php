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
  <link rel="stylesheet" href="HP.css" type="text/css">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <title>Add Patient</title>
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

            <!-- Container (Add Section) -->
            <div id="addpatient" class="container-fluid">
                <div class="container-signup">
                    <div class="title">Add Patient</div>
                    <div class="content">
                        <form id="addForm" action="#" method="POST" onsubmit="return validateForm()">
                            <div class="user-details">
                                <div class="input-box">
                                    <span class="details">Enter ID</span>
<input type="text" name="nid" placeholder="Enter patient's ID" minlength="10" maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57" pattern="^[0-9]*$" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">First Name</span>
                                    <input type="text" id="first_name" name="first_name" placeholder="Enter first name"
                                        pattern="[A-Za-z]+" onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">Last Name</span>
                                    <input type="text" id="last_name" name="last_name" placeholder="Enter last name"
                                        pattern="[A-Za-z]+" onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122)" required>
                                </div>
								<div class="input-box">
                                    <span class="details">Phone No.</span>
                                    <input type="tel" id="tel" name="tel" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">Gender</span>
                                    <select id="gender" name="gender" required>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="input-box">
                                    <span class="details">Date of Birth</span>
                                    <input type="date" id="dob" name="dob" required>
                                </div>
                                <div class="input-box">
                                    <span class="details">Age</span>
                                    <input type="number" id="age" name="age" required readonly>
                                </div>
                            </div>
                            <div class="button">
                              <input type="submit" name="submit" value="Register" >
                            </div>
                              <a class="previous" onclick="goBack()">&laquo; Previous</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#dob').on('change', function(){
                var dob = $(this).val();
                var today = new Date();
                var birthDate = new Date(dob);
                var age = today.getFullYear() - birthDate.getFullYear();
                var m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                $('#age').val(age);
            });
        });
    </script>

    <?php
// Database connection
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve form data
    $PID=$_POST["nid"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $dob = $_POST["dob"];
    $age = $_POST["age"];
	$tel = $_POST["tel"];
    $gender = $_POST["gender"]; // Retrieve gender value
    $email=$_SESSION['email'];
   $check_sql = "SELECT * FROM patient WHERE PatientID='$PID'";
    $result = $conn->query($check_sql);
     if ($result->num_rows > 0) {
        // User already exists
       echo '<script>alert("User already exists");</script>';
     }else{
        $er="SELECT physiologistId FROM physiologist where email='$email'";
         $r = $conn->query($er);
if ($r->num_rows > 0) {
    $row = $r->fetch_assoc(); // Fetch the row from the result
    $physiologistId = $row['physiologistId']; // Get the value of 'physiologistId' column
    // Insert data into database
    $sql = "INSERT INTO patient (PatientID,FirstName, LastName, DOB, phoneNo, Age, Gender, physiologist) 
            VALUES ('$PID','$first_name', '$last_name', '$dob', '$tel', $age, '$gender', $physiologistId)";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("New record created successfully");</script>';
    } else {
        echo '<script>alert("Sorry we cannot create new record, Try again ");</script>';
    }
} else {
    echo '<script>alert("Physiologist not found");</script>';
}

}
}
// Close connection
$conn->close();
?>

</body>

</html>