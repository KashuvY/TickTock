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

// Retrieve form data
$employeeId = $_POST['employee_id'];
$date = $_POST['date'];
$reason = $_POST['reason'];

// SQL query to insert the request into the database
$sql = "INSERT INTO edit_requests (employee_id, date, reason) VALUES (?, ?, ?)";

// Prepare statement
$stmt = $conn->prepare($sql);

// Bind parameters and execute
$stmt->bind_param("iss", $employeeId, $date, $reason);
if ($stmt->execute()) {
    echo "Edit request submitted successfully!";
} else {
    echo "Error submitting edit request: " . $conn->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
