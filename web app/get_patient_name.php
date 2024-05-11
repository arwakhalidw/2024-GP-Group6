<?php
session_start();
// Check if the National ID is provided via POST request
if(isset($_POST['nid'])) {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "ADPrediction";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

	$er = $_SESSION['email'];
	$e = "SELECT physiologistId FROM physiologist where email='$er'";
	$p = $conn->query($e);
	$ro = $p->fetch_assoc(); // Fetch the row from the result
	$phys = $ro['physiologistId']; // Get the value of 'physiologistId' column
    $nid = $_POST['nid']; // National ID provided via POST request
    $sql = "SELECT CONCAT(FirstName, ' ', LastName) AS FullName FROM patient WHERE PatientID = '$nid' and physiologist='$phys'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // If patient found, fetch the name
        $row = $result->fetch_assoc();
        $fullName = $row["FullName"];

        echo $fullName;
    } else {
        echo "ID does not Exist";
    }

    // Close connection
    $conn->close();
} else {

    echo "ID is not SET.";
}
?>
