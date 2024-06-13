<?php
// data.php

// Start session
session_start();

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

// Get username from session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT fullname, roll, age, pnumber, email FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        $data = ["error" => "No data found for the given username"];
    }

    $stmt->close();
} else {
    // Handle case where username is not set in session
    $data = ["error" => "Username not found in session"];
}

$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>

