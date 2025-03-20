<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $full_name = $_POST["full_name"];
    $new_password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

   
    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
        echo "<script>window.location = 'forgot.php';</script>";
    } else {
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "registration_system";

        
        $conn = new mysqli($servername, $username, $password, $dbname);

    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        $sql = "UPDATE users SET password = '" . $new_password . "' WHERE full_name = '" . $full_name. "'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Password reset successfully');</script>";
            echo "<script>window.location = 'login.php';</script>";
        } else {
            echo "Error updating password: " . $conn->error;
        }

        $conn->close();
    }
}
?>

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Do</title>
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
            padding: 10px;
            overflow: hidden;
        }

    div img {
        float: left;
        margin-right: 10px;
        height: 100px;
        margin-top: 2px;
    }

    div h1 {
        margin: 0;
        line-height: 50px;
        color: #fff;
        font-size: 50px;
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
        <h2> <img src="IMAGES/download 12.png"></h2><br>
            <h1>REGISTRATION RECORD </h1>
        </div><br><br>
        <section>
            <h1 style="text-align: center;color: green;">RESET PASSWORD</h1>
            <nav>
                <form method="post">
                    <label>USER NAME</label><br>
                    <input type="text" name="full_name" required><br><br>
                    <label>NEW PASSWORD:</label><br>
                    <input type="password" name="password" required><br><br>
                    <label>RE-ENTER PASSWORD:</label><br>
                    <input type="password" name="confirm_password" required><br><br>
                    <button type="submit" name="submit" style="display: block; margin: 0 auto;background-color: green;color: #fff;">RESET</button><br>
                </form>
            </nav>
        </section>
</body>
</html>





