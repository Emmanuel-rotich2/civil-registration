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