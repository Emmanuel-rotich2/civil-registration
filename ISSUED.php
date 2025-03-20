<?php
header("Content-Type: application/json");
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "registration_system";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database Connection Failed: " . $conn->connect_error]));
}

if (isset($_GET['searchDate'])) {
    $searchDate = $_GET['searchDate'];
    $stmt = $conn->prepare("SELECT COUNT(*) AS totalCertificates FROM current_application WHERE recordISSUED = ?");
    if ($stmt === false) {
        die(json_encode(["error" => "SQL Prepare Error: " . $conn->error]));
    }

    $stmt->bind_param("s", $searchDate);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $totalCertificates = 0;
    if ($row = $result->fetch_assoc()) {
        $totalCertificates = $row['totalCertificates'];
    }

    $stmt->close();
    $conn->close();

    echo json_encode(["count" => $totalCertificates]);
} else {
    echo json_encode(["error" => "No date provided"]);
}
?>
