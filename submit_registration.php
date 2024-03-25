<?php
// Database connection info
$host = 'localhost'; // Host name, usually 'localhost' for XAMPP
$username = 'root'; // Default XAMPP MySQL username is 'root'
$password = ''; // Default XAMPP MySQL password is empty
$dbname = 'userDatabase'; // Your database name

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
$employeeID = $_POST['employeeID'];
//$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
$password = $_POST['password']; //no hash for now

// Verify password retype matches
if ($_POST['password'] !== $_POST['passwordRetype']) {
    die('Passwords do not match.');
}

// SQL query to insert data
$sql = "INSERT INTO users (first_name, last_name, email, employee_id, password) VALUES (?, ?, ?, ?, ?)";

// Prepare statement
$stmt = $conn->prepare($sql);

// Bind parameters and execute
$stmt->bind_param("sssii", $firstName, $lastName, $email, $employeeID, $password);
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
