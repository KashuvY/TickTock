<?php
// Database connection info
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'userDatabase';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$companyID = $_POST['companyID'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
$accessLevel = 0; // everyone gets set to regular employee, permissions get set after

// Verify password retype matches
if ($_POST['password'] !== $_POST['passwordRetype']) {
    die('Passwords do not match.');
}

// SQL query to insert data
$sql = "INSERT INTO users (first_name, last_name, email, company_id, password, access_level) VALUES (?, ?, ?, ?, ?, ?)";

// Prepare statement
$stmt = $conn->prepare($sql);

// Bind parameters and execute
$stmt->bind_param("sssisi", $firstName, $lastName, $email, $companyID, $password, $accessLevel);

if ($stmt->execute()) {
    echo "New record created successfully";
    header('Location: /TickTock/pages/login.html');
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>