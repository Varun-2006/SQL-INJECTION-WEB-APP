<?php
// MySQL database connection settings
$servername = "localhost:3306";
$username = "root";
$password = "Varun@2006";
$database = "testDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $roll_number = $_POST["roll_number"];
    $age = $_POST["age"];
    $mobile_number = $_POST["mobile_number"];
    $email = $_POST["email"];

    // SQL query to insert data into the users table
    $sql = "SELECT * FROM users WHERE username=$entered_username INSERT INTO users (fullname, roll, age,pnumber, email) 
            VALUES ('$full_name', '$roll_number', $age, $mobile_number, '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>

