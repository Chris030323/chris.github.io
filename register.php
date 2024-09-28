<?php
$dsn ="mysql:host=localhost;dbname=eventplanner";
$user = "root";
$password = "";
$db = "user";

session_start();
include('./db_connect.php');
 
$username = $password = $confirm_password = $role = "";
$username_err = $password_err = $confirm_password_err = $role_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else {
        $sql_check = "SELECT id FROM login WHERE username = ?";

        if ($stmt_check = mysqli_prepare($link, $sql_check)) {
            mysqli_stmt_bind_param($stmt_check, "s", $param_username_check);
            $param_username_check = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmt_check)) {
                mysqli_stmt_store_result($stmt_check);

                if (mysqli_stmt_num_rows($stmt_check) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim ($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt_check);
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim ($_POST["confirm_password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "Password did not match.";
        }
    }

    if (empty(trim($_POST["role"]))) {
        $role_err = "Please select a role.";
    } else {
        $role = trim($_POST["role"]);
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($role_err)) {
        $sql = "INSERT INTO login (username, password, role) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            $param_username = $username;
            $param_password = $password;
            $param_role = $role;

            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_role);

            if (mysqli_stmt_execute($stmt)) {
                header("location :login.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | CLYS Event Planner</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.boothstrapcdn.com/font-awsome/4.7.0/css/font-awsome.min.css">
</head>
<body>
    <div class="container">
        <div class="logo">
        <img src="clys logo.png" width="100px" alt="CLYS">
        </a>
    </div>
    <h1>Register</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label>Uername</label>
            <input type="text" name="usermame" value="<?php echo $username; ?>"required>
            <span class="help-block"><?php echo $username_err;?></span>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
            <span class="help-block"><?php echo $password_err;?></span>
        </div>
        <div>
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>
            <span class="help-block"><?php echo $confirm_password_err;?></span>
        </div>
        <div>
            <label>Role</label>
            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="admin">Admin</option>
                <option value="Customer">Customer</option>
            </select>
            <span class="help-block"><?php echo $role_err; ?></span>
        </div>
        <div>
            <input type="submit" name="register" value="Register" class="btn">
        </div>
    </form>
</div>

<!--Footer-->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <h3>Contact Us</h3>
                <p>Email: customerservice@clys.com</p>
                <p>Phone: +60 19-4289525</p>
                <p>Address: 123, Street ABC, Cheras, Malaysia</p>
            </div>
        </div>
    </div>
    </footer>
</body>
<style>
    body 
    {
        align-items: center;
        background-color: #cceeff;
        font-family: sans-serif;
        padding-top: 100px;
        margin: 0;
    }

    .container 
    {
        width: 25%;
        margin: 0 auto;
        overflow: hidden;
        text-align: center;
    }

    h1 
    {
        color: black;
        margin-bottom: 40px;
        font-weight: bold;
    }

    form 
    {
        margin-bottom: 20px;
    }

    form label 
    {
        display: block;
        margin-top: 5px;
        margin-bottom: 5px;
        text-align: center;
    }

    input[type="text"],
    input[type="password"],
    select 
    {
        width: calc(100% - 12px);
        padding: 16px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        border-width: border-box;
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

    .footer
    {
        background-color: #cceeff;
        padding: 20px 0;
        width: 100%;
        margin-top: auto;
        color: black;
    }

    .footer .container 
    {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .footer .content 
    {
        max-width: 600px;
    }

    .footer .content h3,
    .footer .content p 
    {
        margin: 5px 0;
    }
</style>
</html>