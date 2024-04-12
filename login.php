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
$username = $_POST['email'];
$password = $_POST['password'];

// SQL query to check if the username and password match a record in the users table
$sql = "SELECT * FROM users WHERE Email = ? AND Password = ?";

// Prepare statement
$stmt = $conn->prepare($sql);

// Bind parameters and execute
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if a matching record is found
if ($result->num_rows === 1) {
    // Login successful, store user information in session variables
    $user = $result->fetch_assoc();
    session_start();
    $_SESSION['UserID'] = $user['UserID'];
    $_SESSION['FirstName'] = $user['FirstName'];
    $_SESSION['LastName'] = $user['LastName'];
    $_SESSION['Email'] = $user['Email'];
    $_SESSION['CompanyID'] = $user['companyID'];
    $_SESSION['AccessLevel'] = $user['AccessLevel'];

    // Redirect to the user information page
    header("Location: user_info.php");
    exit();
} else {
    // Login failed, display an error message or redirect back to the login page
    echo "Invalid username or password";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>