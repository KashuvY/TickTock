<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TickTock - All Employees</title>
    <link rel="stylesheet" href="../css/UserStyles.css">
</head>

<body>
    <!-- Top navigation bar -->
    <div class="hero">
        <nav>
            <img src="../images/clock.png" class="logo">
            <ul>
                <li><a href="EmployeeTimelogs.html" class="nav-bar">Employee Logs</a></li>
                <li><a href="UserTimelogs.html" class="nav-bar">Personal Logs</a></li>
                <li><a href="ManageUsers.html" class="nav-bar">Manage Users</a></li>
                <li><a href="ManageProjects.html" class="nav-bar">Manage Projects</a></li>
                <li><a href="CreateProjects.html" class="nav-bar">Create Projects</a></li>
            </ul>
            <div>
                <!-- No functionality for actual Sign Out button -->
                <!-- <a href="#" class="download-button">Sign Out</a> -->
                <!-- Logout button that works but doesnt look as nice -->
                <form action="../logout.php" method="post">  
                    <input type="submit" name="logout" value="Logout"> 
                </form> 
            </div>
        </nav>
        <div>
            <table>
                <th>Employee ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Access Level</th>

                <?php 
                $host = "localhost";
                $username = "root";
                $password = "";
                $dbname = "userDatabase";

                $conn = new mysqli($host, $username, $password, $dbname);

                // Check for connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);

                //dynamically displays the projects stored in the database

                function getAccessLevelText($access_level) {
                    switch ($access_level) {
                        case 0:
                            return "Employee";
                        case 1:
                            return "Manager";
                        case 2:
                            return "Admin";
                        default:
                            return "Unknown";
                    }
                }      

                // echos information about employees from relevant project
                if ($result->num_rows > 0) {
                    while ($row = $result-> fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><span>" . $row["user_id"] . "</span></td>";
                        echo "<td><span>" . $row["first_name"] . "</span></td>";
                        echo "<td><span>" . $row["last_name"] . "</span></td>";
                        echo "<td><span>" . getAccessLevelText($row["access_level"]) . "</span></td>";
                        echo "</tr>";                         
                    }
                } else {
                    echo "No users found.";
                }

                $conn->close();
                ?>
            </table>
        </div>
        </div>
        <!-- <div class="content">
            <a href="../logout.php" class="download-button">Sign Out</a>
        </div> -->
        <form action="../logout.php" method="post"> 
            <input type="submit" name="logout" value="Logout"> 
        </form> 
    </div> 
</body>
</html>