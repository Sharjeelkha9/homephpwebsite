<?php
$servername = "localhost";  // Your MySQL host (often 'localhost')
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password
$dbname = "student_db";      // The database you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Insert into database
$sql = "INSERT INTO students (first_name, last_name, email, phone, reg_date) 
        VALUES ('$first_name', '$last_name', '$email', '$phone', NOW())";

if ($conn->query($sql) === TRUE) {
    // Show success alert and then redirect back to the form
    echo "<div class='container mt-5'>";
    echo "<div class='alert alert-success'>New student record created successfully. You will be redirected to the form shortly.</div>";
    echo "</div>";

    // Redirect to the form after 3 seconds
    echo "<meta http-equiv='refresh' content='3;url=index.php'>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();

?>
