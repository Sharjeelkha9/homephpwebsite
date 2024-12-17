<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "";     // Replace with your MySQL password
$dbname = "test";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch form data
$name = $_POST['name'];
$email = $_POST['email'];
$age = $_POST['age'];
$city = $_POST['city'];


// Prepare and bind the SQL statement
$stmt = $conn->prepare("INSERT INTO empyloee (name, email, age, city) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssis", $name, $email, $age, $city );

// Execute the statement
if ($stmt->execute()) {
    echo "New record created successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();

// Redirect back to the form
header("Location: index.php"); // Replace with your form page
exit();
?>
