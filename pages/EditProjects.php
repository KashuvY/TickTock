<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Projects</title>
    <link rel="stylesheet" href="../css/UserStyles.css">
</head>
<body>
    <!-- Top navigation bar -->
    <div class="hero">
        <nav>
            <a href="../index.html"><img src="../images/clock.png" class="logo"></a>
            <ul>
                <li><a href="admin.html">Clock In</a></li>
            </ul>
            <div>
                <a href="login.html" class="login-button">Log in</a>
                <a href="#" class="download-button">Download App</a>
            </div>
        </nav>
    <form action="../edit_project.php" method="POST"> <!-- Form added -->
        <h5>When allowing users to access projects, please insert their employee id into the array. Separate different users with commas. 
            For example: [1, 3, 5] would allow employees with the ids 1, 3, and 5 to access the project.
        </h5>
        <table>
            <th>Project ID</th>
            <th>Project Title</th>
            <th>Project Description</th>
            <th>User Access</th>

            <?php 
            $host = "localhost";
            $username = "root";
            $password = "";
            $dbname = "userDatabase";

            $conn = new mysqli($host, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM projects";
            $result = $conn->query($sql);

            //dynamically displays the projects stored in the database
            if ($result->num_rows > 0) {
                while ($row = $result-> fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><input type='text' name='project_id[]' value='" . $row["project_id"] . "' readonly></td>";
                    echo "<td><input type='text' name='name[]' value='" . $row["name"] . "'></td>";
                    echo "<td><input type='text' name='description[]' value='" . $row["description"] . "'></td>";
                    echo "<td><input type='text' name='user_access[]' value='" . $row["user_access"] . "'></td>";
                    echo "</tr>";
                }
            } else {
                echo "No projects found.";
            }

            $conn->close();
            ?>
        </table>
        <button type="submit">Save Changes</button> <!-- Submit button added -->
    </form> <!-- Form closing tag -->
</body>
</html>
