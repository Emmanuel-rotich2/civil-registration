<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "registration_system";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recordAPPLIC = mysqli_real_escape_string($conn, $_POST['recordAPPLIC']);
    $recordDATER = mysqli_real_escape_string($conn, $_POST['recordDATER']);
    $recordNAMEAP = mysqli_real_escape_string($conn, $_POST['recordNAMEAP']);
    $recordNUM = mysqli_real_escape_string($conn, $_POST['recordNUM']);
    $recordTYPE = mysqli_real_escape_string($conn, $_POST['recordTYPE']);
    $recordOWNER = mysqli_real_escape_string($conn, $_POST['recordOWNER']);
    $recordPLACE = mysqli_real_escape_string($conn, $_POST['recordPLACE']);
    $recordENTRY = mysqli_real_escape_string($conn, $_POST['recordENTRY']);
    $recordDATE = mysqli_real_escape_string($conn, $_POST['recordDATE']);
    $recordCERT = mysqli_real_escape_string($conn, $_POST['recordCERT']);
    $recordISSUED = mysqli_real_escape_string($conn, $_POST['recordISSUED']);
    $recordNAME = mysqli_real_escape_string($conn, $_POST['recordNAME']);
    $recordPHONE = mysqli_real_escape_string($conn, $_POST['recordPHONE']);
    $recordID = mysqli_real_escape_string($conn, $_POST['recordID']);
    $formatted_phone = substr($recordPHONE, 0, 2) . str_repeat('*', 5) . substr($recordPHONE, -3);
    $formatted_NUM = substr($recordNUM, 0, 2) . str_repeat('*', 5) . substr($recordNUM, -3);


    $checkQuery = "SELECT * FROM current_application WHERE recordNAMEAP = '$recordNAMEAP'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
    
        echo "<script>alert('Duplicate record! The name of the applicant already exists.');</script>";
    } else {
       
        $sql = "INSERT INTO current_application (recordAPPLIC, recordDATER, recordNAMEAP, recordNUM, recordTYPE, recordOWNER, 
                recordPLACE, recordENTRY, recordDATE, recordCERT, recordISSUED, recordNAME, recordPHONE, recordID) 
                VALUES ('$recordAPPLIC', '$recordDATER', '$recordNAMEAP', '$formatted_NUM', '$recordTYPE', '$recordOWNER', 
                '$recordPLACE', '$recordENTRY', '$recordDATE', '$recordCERT', '$recordISSUED', '$recordNAME', '$formatted_phone', 
                '$recordID')";
                $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('Record successfully added');</script>";
            echo "<script>window.location = 'CA.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        $idCount = 0;
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['searchDate'])) {
    $searchDate = $_GET['searchDate'];
    $stmt = $conn->prepare("SELECT COUNT(*) FROM cards WHERE recordDATE = ?");
    $stmt->bind_param("s", $searchDate);
    $stmt->execute();
    $stmt->bind_result($idCount);
    $stmt->fetch();
    $stmt->close();
}

    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Book</title>
   <link rel="stylesheet" href="ca.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <style>
        .static-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: crimson;
            text-align: center;
            padding: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        body {
            padding-top: 120px; 
        }
    </style>
</head>

<body>
<section class="static-header">
<h2> <img src="IMAGES/download 12.png" style="  float: left;
            margin-right: 10px;
            height: 100px;"></h2><br>
        <h1 style="color: #fff;font-size:30px;margin: 0;
            line-height: 50px">CIVIL REGISTRY</h1>
        <a href="index.php" style="color: #000;float: right; margin-right:20px;"><i class="fa fa-backward" aria-hidden="true">Back</i></a><br>
    </section><br><br>``
    <form id="recordForm" method="post">
  
    <div style="background-color:  lightgreen; padding: 10px; margin-bottom: 20px;">
        <h2>Applicant Information</h2>
        <label for="recordAPPLIC">APPLICATION SNO:</label>
        <input type="text" id="recordAPPLIC" name="recordAPPLIC" required>
        <label for="recordDATER">DATE RECEIVED:</label>
        <input type="date" id="recordDATER" name="recordDATER" required>
        <label for="recordNAMEAP">NAME OF APPLICANT:</label>
        <input type="text" id="recordNAMEAP" name="recordNAMEAP" required>
        <label for="recordNUM">PHONE NO:</label>
        <input type="text" id="recordNUM" name="recordNUM" required>
    </div>

    <div style="background-color:  lightgreen; padding: 10px; margin-bottom: 20px;">
        <h2>Certificate Information</h2><br>
        <label for="recordTYPE">CERTIFICATE TYPE:</label>
      <select  type="text" id="recordTYPE" name="recordTYPE" required>
        <option  ></option>
        <option>Birth</option>
        <option>Dead</option>
    </select>
        <label for="recordOWNER">NAME OF OWNER:</label>
        <input type="text" id="recordOWNER" name="recordOWNER" required>
        <label for="recordPLACE">PLACE OF BIRTH:</label>
        <input type="text" id="recordPLACE" name="recordPLACE" required>
        <label for="recordENTRY">ENTRY NO:</label>
        <input type="text" id="recordENTRY" name="recordENTRY" required><br><br>
        <label for="recordDATE">DATE OF BIRTH:</label>
        <input type="date" id="recordDATE" name="recordDATE" >
        <label for="recordCERT">CERT NO:</label>
        <input type="text" id="recordCERT" name="recordCERT" >
        <label for="recordISSUED">DATE ISSUED:</label>
        <input type="date" id="recordISSUED" name="recordISSUED">
        </div>
        <div style="background-color: lightgreen; padding: 10px;">
        <h2>Issued To</h2><br>
        <label for="recordNAME">NAME :</label>
        <input type="text" id="recordNAME" name="recordNAME">
        <label for="recordPHONE">PHONE NO:</label>
        <input type="text" id="recordPHONE" name="recordPHONE">
        <label for="recordID">ID NO:</label>
        <input type="text" id="recordID" name="recordID">
         </div>
 <div style="text-align: center; margin-top: 20px;">
        <button type="submit" style="background-color:green;color:#fff;">Add Record</button>
    </div><br>
    
</form>
<form id="certificateForm" style="margin-left:">
    <label for="searchDate">Select Date:</label>
    <input type="date" id="searchDate" name="searchDate" required>
    <button type="button" onclick="getCertificateCount()">Get Count</button>
</form>

<div id="certificateCount" style="margin-top: 20px; font-size: 20px; font-weight: bold; color: green;"></div>

<script>
function getCertificateCount() {
    var searchDate = document.getElementById("searchDate").value;

    if (searchDate) {
        fetch("ISSUED.php?searchDate=" + searchDate)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById("certificateCount").innerHTML = 
                        "<span style='color:red;'>" + data.error + "</span>";
                } else {
                    document.getElementById("certificateCount").innerHTML = 
                        "Total Certificates Issued on " + searchDate + ": <strong>" + data.count + "</strong>";
                }
            })
            .catch(error => console.error("Error fetching data:", error));
    } else {
        alert("Please select a date.");
    }
}
</script>


    <div style="text-align: center;">
    <input type="text" id="searchInput" placeholder="Search..." oninput="searchRecords()">
    <button type="reset" id="resetButton" style="background-color:green;color:#fff;">Get records</button> 
</div><br><br>
<table id="recordTable">
    <thead>
        <tr>
            <th>APPLICATION SNO</th>
            <th>DATE RECEIVED</th>
            <th>NAME OF APPLICANT</th>
            <th>PHONE NO</th>
            <th>CERTIFICATE TYPE</th>
            <th>NAME OF OWNER</th>
            <th>PLACE OF BIRTH</th>
            <th>ENTRY NO</th>
            <th>DATE OF BIRTH</th>
            <th>CERT NO</th>
            <th>DATE ISSUED</th>
            <th>ISSUED TO</th>
            <th>PHONE NUMBER</th>
            <th>ID NUMBER</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

    <script>
    function searchRecords() {
        var input, filter;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var records = JSON.parse(this.responseText);
                updateTable(records);
            }
        };
        xhr.open("GET", "search.php?q=" + filter, true);
        xhr.send();
    }
    function updateTable(records) {
        var tableBody = document.querySelector("#recordTable tbody");
        tableBody.innerHTML = "";

        records.forEach(function (record) {
            var newRow = document.createElement("tr");
            newRow.innerHTML = "<td>" + record.recordAPPLIC + "</td>" +
                "<td>" + record.recordDATER + "</td>" +
                "<td>" + record.recordNAMEAP + "</td>" +
                "<td>" + record.recordNUM + "</td>" +
                "<td>" + record.recordTYPE + "</td>" +
                "<td>" + record.recordOWNER + "</td>" +
                "<td>" + record.recordPLACE + "</td>" +
                "<td>" + record.recordENTRY + "</td>" +
                "<td>" + record.recordDATE + "</td>" +
                "<td>" + record.recordCERT + "</td>" +
                "<td>" + record.recordISSUED + "</td>" +
                "<td>" + record.recordNAME + "</td>" +
                "<td>" + record.recordPHONE + "</td>"+
                "<td>" + record.recordID + "</td>";
            tableBody.appendChild(newRow);
        });
    }
</script>
<script>
    document.getElementById("resetButton").addEventListener("click", function() {
        var searchTerm = document.getElementById("searchInput").value;
        searchRecords(searchTerm); 
    });
</script>

</body>

</html>

