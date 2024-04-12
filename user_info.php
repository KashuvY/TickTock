<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    // User is not logged in, redirect to the login page
    header("Location: pages/login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['FirstName'] . ' ' . $_SESSION['LastName']; ?></h1>
    <p>Email: <?php echo $_SESSION['Email']; ?></p>
    <p>Company ID: <?php echo $_SESSION['CompanyID']; ?></p>
    <p>Access Level: <?php echo $_SESSION['AccessLevel']; ?></p>
</body>
</html>