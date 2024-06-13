<?php
// Start session
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $form_type = $_POST['form_type'];

    if ($form_type === 'login_form') {
        // Get username and password from form
        $entered_username = $_POST['username'];
        $entered_password = $_POST['password'];

        // Prepare SQL query to check if the username and password match
        $sql = "SELECT * FROM users WHERE username='$entered_username' AND password='$entered_password' AND age IS NULL";
        $result = $conn->query($sql);
        
        $sqli="SELECT * FROM users WHERE username='$entered_username' AND password='$entered_password'";
        
        $resulti= $conn->query($sqli);

        // Check if any row is returned
        if ($result->num_rows > 0) {
            // Login successful
            $_SESSION['username'] = $entered_username; // Store username in session
            header("Location: 2.html"); // Redirect the user to another page
            exit;
        } else {
              if($resulti->num_rows > 0){
              
              $_SESSION['username'] = $entered_username; // Store username in session
            header("Location: 5.html"); // Redirect the user to another page
              
              }
              
              else{
           // Login failed
            $error = urlencode("Invalid username or password");
            header("Location: 1.html?error=$error"); // Redirect back to login with error
            exit; } 
        }
    }

    if ($form_type === 'credentials_form') {
     if (isset($_SESSION['username'])) {
            $user_name = $_SESSION['username'];

            // Get additional data from form
            $full_name = $_POST["full_name"];
            $roll_number = $_POST["roll_number"];
            $age = $_POST["age"];
            $mobile_number = $_POST["mobile_number"];
            $email = $_POST["email"];

            // SQL query to insert or update data into the users table
            $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
            $stmt->bind_param("s", $user_name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Username exists, update the existing row
                $stmt = $conn->prepare("UPDATE users SET fullname=?, roll=?, age=?, pnumber=?, email=? WHERE username=?");
                $stmt->bind_param("ssisss", $full_name, $roll_number, $age, $mobile_number, $email, $user_name);
                if ($stmt->execute() === TRUE) {
                    header("Location: 5.html");
                    exit;
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            } else {
                echo "Username not found.";
            }
        } else {
            // Username not found in session, handle error
            echo "Username not found in session.";
        }
    }
}

// Close connection
$conn->close();
?>

