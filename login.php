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
    $full_name = $_POST["full_name"];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE full_name='$full_name' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        echo "<script>alert('login successfully !!');</script>";
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Invalid national ID or password. Please try again.";
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
            background-image: url(IMAGES/12.jpg);
            background-position: center;
            background-size: cover;
            height: 100vh;
        }

        div {
            background-color: red;
            text-align: center;
            overflow: hidden;
        }

        div img {
            float: left;
            margin-right: 10px;
            height: 100px;
        }

        div h1 {
            line-height: 30px;
            color: #fff;
            font-size: 45px;
            margin-top:0px;
        }

        nav {
            text-align: center;
        }

        section {
            background-color: cornsilk;
            width: 340px;
            margin: auto;
            padding: 20px;
        }
    </style> 
</head>
<body>
    <div>
        <h2><img src="IMAGES/download 12.png"></h2>
        <h1>HUDUMA RECORD MANAGEMENT SYSTEM</h1>
    </div><br><br>
    <section>
        <h1 style="text-align: center;color: green;">USER LOGIN</h1>
        <nav>
            <form method="post">
                <label>USER NAME:</label><br>
                <input type="text" name="full_name" required><br><br>
                <label>PASSWORD:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <input type="checkbox" id="showPassword" onclick="togglePassword()"> Show Password<br><br>
                <input type="checkbox" name="remember_me"> Remember me<br><br>
                <button type="submit" name="submit" style="display: block; margin: 0 auto;background-color: green;color: #fff;">LOGIN</button><br>
            </form>

            <a href="forgot.php">Forget password</a><br>
            <h1>Do not have an account?<a href="register.php"> Register</a></h1>
        </nav>
    </section>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var showPasswordCheckbox = document.getElementById("showPassword");
            if (showPasswordCheckbox.checked) {
                passwordField.type = "text";
            } else {
                passwordField.type = "password"; 
            }
        }
    </script>
</body>

</html>
