<?php
$dsn ="mysql:host=localhost;dbname=eventplanner";
$username = "root";
$password = "";
$database = "user";

session_start();
include('./db_connect.php');

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $_SESSION["username"] = $username;
        $_SESSION["role"] = $row["row"];

        if ($_SESSION["role"] == "admin") {
            header("Location: admin.php");
            exit();
        } elseif ($_SESSION["role"] == "customer") {
            header("location: Homepage.php");
            exit();
        }
    } else {
            $error_message = "Uusername or passsword is incorrect, Please try again";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | CLYS Event Planner</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container text-center">
        <div class="logo">
            <img src="clys logo.png.png" width="200px" alt="CLYS">
        </div>
    <h1>Login</h1>
    <form action="#" method="POST">
        <div>
            <label>Username</label>
            <input type="text" name="username" required class="input-field">
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required class="input-field">
        </div>
        <div class="error-message">
            <?php echo isset($error_message) ? $error_message : ''; ?>
        </div>
        <div>
            <input type="submit" value="Login">
        </div>
    </form>
</div>

<footer class="footer">
    <div class ="container">
        <div class="row">
            <div class="col-3">
                <h3>Contact Us</h3>
                <p>Email: customerservier@clys.com</p>
                <p>Phone: +6019-4289525</p>
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
        color:black;
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
        box-sizing: border-box;
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
<?php
$conn->close();
?>