<?php
// Database connection
$dsn ="mysql:host=localhost;dbname=eventplanner";
$username = "root";
$password = "";
$database = "user";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Add admin account
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_admin'])) {
        // Add admin account
        $admin_username = sanitize_input($_POST['admin_username']);
        $admin_password = sanitize_input($_POST['admin_password']);

        // Check if the username already exists
        $check_username_sql = "SELECT * FROM login WHERE username='$admin_username'";
        $check_username_result = $conn->query($check_username_sql);
        if ($check_username_result->num_rows > 0) {
            echo "<script>alert('Username already exists. Please choose a different username.');</script>";
        } else {
            // Insert data into database with user type as admin
            $insert_sql = "INSERT INTO login (username, password) VALUES ('$admin_username', '$admin_password', 'admin')";
            if ($conn->query($insert_sql) === TRUE) {
                echo "<script>alert('Admin account added successfully');</script>";
                // Redirect to refresh the page
                echo "<script>window.location.href='manageadmin.php';</script>";
            } else {
                echo "Error adding admin account: " . $conn->error;
            }
        }
    } elseif (isset($_POST['edit_admin'])) {
        // Edit admin account
        // Your edit admin account code here
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admin Accounts | CLYS Event Planning</title>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <div class="logo">
                    <img src="clys logo.png.png" width="100px" alt="Jny">
                </a>
            </div>
            <nav>
                <ul>
                    <a href="admin.php" class="nav-icon">
                        <img src="admin icon.jpg" width="30px" height="30px" alt="Admin">
                    </a>
                    <a href="login.php" class="nav-icon"> 
                        <img src="log out icon.jpg" width="30px" height="30px" alt="Log Out">
                    </a>
                </ul>
            </nav>
        </div>
        <div class="container">
            <h2>Manage Admin Accounts</h2>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>
                <?php
                // Fetch all admin accounts where user type is "admin"
                $sql = "SELECT * FROM login WHERE role='admin'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . $row["password"] . "</td>";
                                echo "<td class='action-links'>
                                        <a href='javascript:void(0)' onclick='toggleForm(\"editAdminForm" . $row["id"] . "\")'>Edit</a> 
                                        <a href='manageadmin.php?delete_id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this admin account?\")'>Delete</a>
                                      </td>";
                        echo "</tr>";
                                // Edit admin form
                                echo "<div class='form-container' id='editAdminForm" . $row["id"] . "' style='display:none;'>";
                                echo "<h3>Edit Admin Account</h3>";
                                echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
                                echo "<input type='hidden' name='admin_id' value='" . $row['id'] . "'>";
                                echo "<label for='admin_username'>Username:</label>";
                                echo "<input type='text' name='admin_username' value='" . $row['username'] . "' required><br>";
                                echo "<label for='admin_password'>Password:</label>";
                                echo "<input type='password' name='admin_password' value='" . $row['password'] . "' required><br>";
                                echo "<input type='submit' name='edit_admin' value='Edit Admin'>";
                                echo "</form>";
                                echo "</div>";
                                echo "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr>No admin accounts found</td></tr>";
                }
                ?>
            </table>

            <!-- Button to toggle the add admin form -->
            <button class="btn" type="addadmin" name="addadmin" onclick="toggleForm('addAdminForm')">Add Admin</button>

            <!-- Add admin form -->
            <div class="form-container" id="addAdminForm" style="display: none;">
                <h3>Add Admin Account</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <label for="admin_username">Username:</label>
                    <input type="text" name="admin_username" required><br>
                    <label for="admin_password">Password:</label>
                    <input type="password" name="admin_password" required><br>
                    <input type="submit" name="add_admin" value="Add Admin">
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript function to toggle form visibility
        function toggleForm(formId) {
            var form = document.getElementById(formId);
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }
    </script>
</body>
<style>
    body 
    {
        font-family:  sans-serif;
        margin: 0;
        padding: 0;
    }

.navbar 
{
    background-color: #ffffff;
    padding: 30px;
    padding-bottom: 70px;
    display: flex;
    align-items: flex-end;
}

.navbar .logo 
{
    display: flex;
    align-items: flex-end;
}

.navbar nav 
{
    margin-left: auto; /* Move the navigation icons to the right */
}

.navbar nav ul a 
{
    margin-right: 30px; /* Gap value between each icon */
}

h2 
{
    text-align: center;
    color: #333;
}

table 
{
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td 
{
    background-color: white;
    border: 2px solid black;
    padding: 8px;
    text-align: center;
}

th 
{
    background-color: #cceeff;
    font-weight: bold;
}

.action-links a 
{
    margin-right: 5px;
    color: #007bff;
    text-decoration: none;
    }

    .action-links a:hover 
    {
        text-decoration: underline;
    }

    .btn 
    {
        display: inline-block;
        background:#ff523b;
        color:#fff;
        padding: 8px 30px;
        margin: 30px 0;
        border-radius: 30px;
        transition:background 0.5s;
    }

    .btn:hover 
    {
        background:#563434;
    }

    .form-container 
    {
        display: none;
        margin-top: 20px;
        border-top: 1px solid #ddd;
        padding-top: 20px;
    }

    .form-container form 
    {
        max-width: 400px;
        margin: 0 auto;
    }

    .form-container input[type="text"],
    .form-container input[type="password"] 
    {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .btn[type="addadmin"] 
    {
        display: inline-block;
        background: #000000;
        color: #fff;
        padding: 8px 30px;
        margin: 30px 0;
        border-radius: 30px;
        cursor: pointer;
    }

.btn[type="addadmin"]:hover 
{
    background: #80ff80;
    color: black;
}

input[type="submit"] 
{
    display: inline-block;
    background: #000000;
    color: #fff;
    padding: 8px 30px;
    margin: 30px 0;
    border-radius: 30px;
    cursor: pointer;
}

input[type="submit"]:hover 
{
    background: #80ff80;
    color: black;
}

.edit-form td 
{
    padding: 0;
    text-align: center;
}

.edit-form .form-container 
{
    display: block;
    border: none;
    padding: 0;
}
</style>
</html>
