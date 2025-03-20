<?php


$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$database = "your_database";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['q'])) {
    $search = $_GET['q'];
    $sql = "SELECT * FROM your_table WHERE column_name LIKE '%$search%'";
    $result = $conn->query($sql);

    $records = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
    }
    echo json_encode($records);
}

$conn->close();
?>
