<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TickTock - Administrator Homepage</title>
    <link rel="stylesheet" href="../css/UserStyles.css">
</head>
<body>
    <!-- Top navigation bar -->
    <div class="hero">
        <nav>
            <img src="../images/clock.png" class="logo">
            <ul>
                <li><a href="UserTimelogs.php" class="nav-bar">Personal Logs</a></li>
            </ul>
            <div>
                <form action="../logout.php" method="post">  
                    <input type="submit" name="logout" value="Logout"> 
                </form> 
            </div>
        </nav>
        <div>
            <?php
            // Check if the user is logged in
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
            
            // Check if the user is currently clocked in
            $sql = "SELECT project_id FROM time_entries WHERE user_id = ? AND clock_out_time IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // User is currently clocked in
                $row = $result->fetch_assoc();
                $clocked_in_project_id = $row['project_id'];
                
                // Retrieve the project name
                $sql = "SELECT name FROM projects WHERE project_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $clocked_in_project_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $project = $result->fetch_assoc();
                $clocked_in_project_name = $project['name'];
                
                echo '<p>You are currently clocked in to: ' . $clocked_in_project_name . '</p>';
                echo '<form action="clock_out.php" method="post">';
                echo '<input type="hidden" name="project_id" value="' . $clocked_in_project_id . '">';
                echo '<label for="work_description">Work Description:</label><br>';
                echo '<textarea name="work_description" rows="4" cols="50"></textarea><br>';
                echo '<input type="submit" name="clock_out" value="Clock Out">';
                echo '</form>';
            } else {
                // User is not clocked in
                echo '<form action="clock_in.php" method="post">';
                echo '<select name="project_id" required>';
                echo '<option value="">Select Project</option>';
                
                // Retrieve projects the user has access to
                $sql = "SELECT project_id, name FROM projects WHERE JSON_CONTAINS(user_access, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($project = $result->fetch_assoc()) {
                    echo "<option value='" . $project['project_id'] . "'>" . $project['name'] . "</option>";
                }
                
                echo '</select>';
                echo '<input type="submit" name="clock_in" value="Clock In">';
                echo '</form>';
            }
            
            // Close statement and connection
            $stmt->close();
            $conn->close();
            ?>
        </div>
        <form action="../logout.php" method="post"> 
            <input type="submit" name="logout" value="Logout"> 
        </form> 
        <div>
            <!-- Chart here that shows their hours for the week -->
        </div>
    </div> 
</body>
</html>