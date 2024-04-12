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
$email = $_POST['email'];
$password = $_POST['password'];

// SQL query to retrieve the user with the provided email
$sql = "SELECT * FROM users WHERE Email = ?";

// Prepare statement
$stmt = $conn->prepare($sql);

// Bind parameter and execute
$stmt->bind_param("s", $email);
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if a matching user is found
if ($result->num_rows === 1) {
    // User found, verify the password
    $user = $result->fetch_assoc();
    $storedPassword = $user['Password'];

    if (password_verify($password, $storedPassword)) {
        // Password is correct, store user information in session variables
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
        // Password is incorrect
        echo "Invalid email or password";
    }
} else {
    // User not found
    echo "Invalid email or password";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>