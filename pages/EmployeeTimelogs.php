<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Timelogs</title>
    <link rel="stylesheet" href="../css/UserStyles.css">
</head>
<body>
    <!-- Top navigation bar -->
    <div class="hero">
        <nav>
            <a href="../index.html"><img src="../images/clock.png" class="logo"></a>
            <ul>
                <!-- Unsure of how to make them return to Post login page relative to what account clearance they have-->
                <li>
                    <?php
                    session_start();
                    // Check if the user is logged in
                    if (isset($_SESSION['UserID'])) {
                        // Retrieve the user's access level from the session
                        $access_level = $_SESSION['AccessLevel'];

                        // Redirect based on the access level
                        switch ($access_level) {
                            case 0:
                                echo '<a href="employee.php" class="nav-bar">Dashboard</a>';
                                break;
                            case 1:
                                echo '<a href="manager.php" class="nav-bar">Dashboard</a>';
                                break;
                            case 2:
                                echo '<a href="admin.php" class="nav-bar">Dashboard</a>';
                                break;
                            default:
                                echo '<a href="login.php" class="nav-bar">Dashboard</a>';
                                break;
                        }
                    } else {
                        // If the user is not logged in, redirect to the login page
                        echo '<a href="login.php" class="nav-bar">Dashboard</a>';
                    }
                    ?>
                </li>
            </ul>
            <div>
                <a href="login.html" class="login-button">Log in</a>
                <a href="#" class="download-button">Download App</a>
            </div>
        </nav>
        <!-- Page Content -->
        <div class="content animation">
            <h1>Employee Timelogs</h1>
            <p>Select a project to view user timelogs:</p>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <select name="project_id" id="projectSelection">
                    <option value="">Select Project</option>
                    <?php
                    // Check if the user is logged in
                    session_start();
                    if (!isset($_SESSION['UserID'])) {
                        header("Location: login.php"); // Redirect to login page if not logged in
                        exit();
                    }

                    // Retrieve user ID from session
                    $user_id = $_SESSION['UserID'];

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

                    // Retrieve projects the user has access to
                    $sql = "SELECT project_id, name FROM projects WHERE JSON_CONTAINS(user_access, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($project = $result->fetch_assoc()) {
                        echo "<option value='" . $project['project_id'] . "'>" . $project['name'] . "</option>";
                    }

                    // Close statement and connection
                    $stmt->close();
                    $conn->close();
                    ?>
                </select>
                <input type="submit" value="View User Timelogs">
            </form>
            <!-- Display the user timelogs for the selected project -->
            <div id="userTimelogs">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Retrieve the selected project ID from the form submission
                    $selected_project_id = $_POST['project_id'];

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

                    // Retrieve users for the selected project
                    $sql = "SELECT u.user_id, u.first_name, u.last_name, u.email
                            FROM users u
                            WHERE JSON_CONTAINS((SELECT user_access FROM projects WHERE project_id = ?), CAST(u.user_id AS CHAR))";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $selected_project_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Display the user timelogs
                    while ($user = $result->fetch_assoc()) {
                        // Retrieve timelogs for the user and selected project
                        $sql = "SELECT p.name AS project_name, te.clock_in_time, te.clock_out_time
                                FROM time_entries te
                                JOIN projects p ON te.project_id = p.project_id
                                WHERE te.user_id = ? AND te.project_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ii", $user['user_id'], $selected_project_id);
                        $stmt->execute();
                        $timelogResult = $stmt->get_result();

                        // Display the user information only if there are timelogs
                        if ($timelogResult->num_rows > 0) {
                            echo "<h3>User: " . $user['first_name'] . " " . $user['last_name'] . "</h3>";
                            echo "<p>Email: " . $user['email'] . "</p>";
                            echo "<p>User ID: " . $user['user_id'] . "</p>";

                            // Display the timelogs for the user
                            while ($timelog = $timelogResult->fetch_assoc()) {
                                echo "<p>" . $timelog['project_name'] . ": Clock In: " . $timelog['clock_in_time'] . ", Clock Out: " . ($timelog['clock_out_time'] ?: 'N/A') . "</p>";
                            }

                            echo "<hr>";
                        }
                    }

                    // Close statement and connection
                    $stmt->close();
                    $conn->close();
                }
                ?>
            </div>
        </div>
        <!-- Page Text -->
        <div>
            <h5>Select a project to view user timelogs.</h5>
        </div>
    </div>
</body>
</html>