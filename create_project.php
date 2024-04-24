<?php
session_start();

// Database connection info
$host = "localhost";
$username = "root";
$password = "";
$dbname = "userDatabase";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$projectName = $_POST['projectName'];
$projectDescription = $_POST['projectDescription'];
$userId = $_SESSION['UserID'];

// Insert project into the database
$sql = "INSERT INTO projects (name, description, user_access) VALUES (?, ?, JSON_ARRAY(?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $projectName, $projectDescription, $userId);
$stmt->execute();

// Close statement and connection
$stmt->close();
$conn->close();

// Redirect back to the admin page
header("Location: pages/admin.php");
exit();
?>