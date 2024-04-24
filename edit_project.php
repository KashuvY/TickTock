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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through the submitted data
    foreach ($_POST['project_id'] as $key => $project_id) {
        // Get the submitted values
        $name = $_POST['name'][$key];
        $description = $_POST['description'][$key];
        $user_access = $_POST['user_access'][$key];

        // Prepare and execute update query
        $sql = "UPDATE projects SET name=?, description=?, user_access=? WHERE project_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $description, $user_access, $project_id);
        $stmt->execute();
    }
    echo "Changes saved successfully.";
}

// Close connection
header("Location: pages/EditProjects.php");
$conn->close();
?>
