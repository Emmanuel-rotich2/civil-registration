<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "registration_system";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST["full_name"]);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $sql = "SELECT * FROM users WHERE full_name='$full_name' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        echo "<script>alert('Login successful!');</script>";
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Invalid username or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        body {
            background: url('IMAGES/12.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            background: red;
            color: white;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }
        .header img {
            height: 50px;
            margin-right: 10px;
        }
        h1 {
            margin: 10px 0;
            font-size: 24px;
            color: green;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            background: green;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: darkgreen;
        }
        .links a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="IMAGES/download 12.png" alt="Logo">
            <h2>HUDUMA RECORD MANAGEMENT SYSTEM</h2>
        </div>
        <h1>User Login</h1>
        <form method="post">
            <label>Username:</label>
            <input type="text" name="full_name" required>
            <label>Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="checkbox" id="showPassword" onclick="togglePassword()"> Show Password
            <br><br>
            <input type="checkbox" name="remember_me"> Remember me
            <br><br>
            <button type="submit">Login</button>
        </form>
        <div class="links">
            <p><a href="forgot.php">Forgot password?</a></p>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
    </div>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            passwordField.type = passwordField.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>