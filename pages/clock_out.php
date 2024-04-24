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
// Retrieve user ID from session
$user_id = $_SESSION['UserID'];

// Retrieve project ID and work description from the form
$project_id = $_POST['project_id'];
$work_description = $_POST['work_description'];

// Get the current time
$clock_out_time = date("Y-m-d H:i:s");

// SQL query to update the clock-out time and work description for the user's active time entry
$sql = "UPDATE time_entries SET clock_out_time = ?, description = ? WHERE user_id = ? AND project_id = ? AND clock_out_time IS NULL";

// Prepare statement
$stmt = $conn->prepare($sql);

// Bind parameters and execute
$stmt->bind_param("ssii", $clock_out_time, $work_description, $user_id, $project_id);
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