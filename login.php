<?php
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
$email = $_POST['email'];
$password = $_POST['password'];

// SQL query to retrieve the user with the provided email
$sql = "SELECT * FROM users WHERE email = ?";

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
    $storedPassword = $user['password'];

    if (password_verify($password, $storedPassword)) {
        // Password is correct, store user information in session variables
        session_start();
        $_SESSION['UserID'] = $user['user_id'];
        $_SESSION['FirstName'] = $user['first_name'];
        $_SESSION['LastName'] = $user['last_name'];
        $_SESSION['Email'] = $user['email'];
        $_SESSION['CompanyID'] = $user['company_id'];
        $_SESSION['AccessLevel'] = $user['access_level'];

        // Redirect to the user information page
        switch ($_SESSION['AccessLevel']) {
            case 0:
                header("Location: pages/employee.php");
                exit();
                break;
            case 1:
                header("Location: pages/manager.php");
                exit();
                break;
            case 2:
                header("Location: pages/admin.php");
                exit();
                break;
            default:
                // Redirect to a default page if access level is not recognized
                echo "Access level not recognized";
                exit();
        }
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