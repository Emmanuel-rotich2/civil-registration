<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $national_id = $_POST["national_id"];
    $full_name = $_POST["full_name"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];

    if (!preg_match('/^[0-9]{1,9}$/', $national_id)) {
        echo "<script>alert('Please enter a valid national ID!'); window.location = 'register.php';</script>";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.location = 'register.php';</script>";
        exit;
    }

    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "registration_system";

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $check_query = "SELECT * FROM users WHERE national_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $national_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('User with this National ID already exists!'); window.location = 'register.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (full_name, national_id, password, phone_number, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $full_name, $national_id, password_hash($password, PASSWORD_DEFAULT), $phone_number, $email);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location = 'login.php';</script>";
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
            <h2>REGISTRATION RECORD SYSTEM</h2>
        </div>
        <h1>Register</h1>
        <form method="post">
            <label>Full Name:</label>
            <input type="text" name="full_name" required>
            <label>National ID:</label>
            <input type="text" name="national_id" required>
            <label>Password:</label>
            <input type="password" id="password" name="password" required>
            <label>Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <input type="checkbox" id="showPassword" onclick="togglePassword()"> Show Password
            <br><br>
            <label>Phone Number:</label>
            <input type="text" name="phone_number" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <br><br>
            <button type="submit">Register</button>
        </form>
        <div class="links">
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var confirmPasswordField = document.getElementById("confirm_password");
            passwordField.type = passwordField.type === "password" ? "text" : "password";
            confirmPasswordField.type = confirmPasswordField.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>
