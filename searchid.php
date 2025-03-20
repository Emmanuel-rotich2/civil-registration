<?php

session_start();

$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "registration_system";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['q']) && !empty($_GET['q'])) {
     
        $searchTerm = $_GET['q'];

        
        $sql = "SELECT * FROM cards  WHERE recordID1 LIKE '%$searchTerm%'";
    } else {
        
        $sql = "SELECT * FROM cards";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
       
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo json_encode(array()); 
    }

    $conn->close();
} else {
    
    echo json_encode(array());
}

?>
