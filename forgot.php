<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $new_password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
        echo "<script>window.location = 'forgot.php';</script>";
        exit;
    }

    if (strlen($new_password) < 8 || !preg_match("/[A-Z]/", $new_password) || !preg_match("/[0-9]/", $new_password) || !preg_match("/[@$!%*?&]/", $new_password)) {
        echo "<script>alert('Password must be at least 8 characters long and include at least one uppercase letter, one number, and one special character.');</script>";
        echo "<script>window.location = 'forgot.php';</script>";
        exit;
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "registration_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE full_name = ?");
    $stmt->bind_param("ss", $hashed_password, $full_name);

    if ($stmt->execute()) {
        echo "<script>alert('Password reset successfully');</script>";
        echo "<script>window.location = 'login.php';</script>";
    } else {
        echo "Error updating password: " . $stmt->error;
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
    <title>Reset Password</title>
    <style>
        body {
            background-image: url(IMAGES/12.jpg);
            background-position: center;
            background-size: cover;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 350px;
            margin: 80px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: green;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reset Password</h1>
        <form method="post">
            <label>Username</label>
            <input type="text" name="full_name" required>
            <label>New Password</label>
            <input type="password" name="password" required>
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>
            <button type="submit">Reset</button>
        </form>
    </div>
</body>
</html>
