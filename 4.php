<?php
// register.php

// Database configuration
$servername = "localhost";
$username = "root";
$password = "Varun@2006";
$dbname = "testDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];
    $rollnumber = $_POST['rollnumber'];

    // Validate the form data
    if (empty($username) || empty($password) || empty($rollnumber)||empty($rollnumber)) {
        echo "All fields are required.";
        exit;
    }
    
        if ($password !== $confirmpassword) {
        echo "Passwords do not match.";
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR roll = ?");
    $stmt->bind_param("ss", $username, $rollnumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "User already exists.";
        $stmt->close();
        $conn->close();
        exit;
    }
    
    $stmt->close();

    

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, password, roll) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $rollnumber);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>

