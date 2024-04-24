<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

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

// Retrieve user ID from session
$user_id = $_SESSION['UserID'];

// Retrieve selected project ID from the form
$project_id = $_POST['project_id'];

// Get the current time
$clock_in_time = date("Y-m-d H:i:s");

// SQL query to insert the clock-in time and project ID into the time_entries table
$sql = "INSERT INTO time_entries (user_id, project_id, clock_in_time) VALUES (?, ?, ?)";

// Prepare statement
$stmt = $conn->prepare($sql);

// Bind parameters and execute
$stmt->bind_param("iis", $user_id, $project_id, $clock_in_time);
$stmt->execute();

// Close statement and connection
$stmt->close();
$conn->close();

switch ($_SESSION['AccessLevel']) {
    case 0:
        header("Location: employee.php");
        exit();
        break;
    case 1:
        header("Location: manager.php");
        exit();
        break;
    case 2:
        header("Location: admin.php");
        exit();
        break;
    default:
        // Redirect to a default page if access level is not recognized
        echo "Access level not recognized";
        exit();
}
exit();
?>