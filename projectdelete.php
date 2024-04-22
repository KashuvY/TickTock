<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if project data is sent in the request
    if (isset($_POST["project"])) {
        // Retrieve the project from the request
        $project = $_POST["project"];

        $deleted = deleteProjectFromDatabase($project);
        if ($deleted) {
            echo "Project deleted successfully!";
        } else {
            http_response_code(500); // Internal Server Error
            echo "Failed to delete project.";
        }

        // Assuming success for demonstration
        echo "Project deleted successfully!";
    } else {
        // If project data is not sent in the request, return an error message
        http_response_code(400); // Bad request
        echo "Project data not provided.";
    }
} else {
    // If the request method is not POST, return an error message
    http_response_code(405); // Method Not Allowed
    echo "Only POST requests are allowed.";
}
?>
