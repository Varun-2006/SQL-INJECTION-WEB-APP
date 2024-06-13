<?php
// Database connection settings
$servername = "localhost:3306"; // Change this to your MySQL server hostname
$username = "root"; // Change this to your MySQL username
$password = "Varun@2006";

$database = "testDB"; // Change this to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username,$password,$database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $entered_username = $_POST['username'];
    $entered_password = $_POST['password'];

    // Prepare SQL query to check if the username and password match
    $sql = "SELECT * FROM users WHERE username='$entered_username' AND password='$entered_password'";
    $result = $conn->query($sql);

    // Check if any row is returned
    if ($result->num_rows > 0) {
        // Login successful
        echo "Login successful!";
	// Redirect the user to another page or perform further actions
	header("Location: 2.html");
	exit();
    } else {
        // Login failed
        
        // Credentials are incorrect, redirect back to login with error
        $error = urlencode("Invalid username or password");
        header("Location: 1.html?error=$error");
        exit;
    }
}

// Close the database connection
$conn->close();
?>

