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
    $volume = $_POST['recordVOLUME'];
    $place_of_birth = $_POST['recordBIRTH'];
    $notification_from = $_POST['recordNOTIFICATION1'];
    $notification_to = $_POST['recordNOTIFICATION2'];
    $entry_from = $_POST['recordENTRY1'];
    $entry_to = $_POST['recordENTRY2'];
    $check_sql = "SELECT * FROM records 
                  WHERE notification_from = '$notification_from' 
                  AND notification_to = '$notification_to'";

    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Duplicate record found for the provided notification range!');</script>";
        echo "<script>window.location = 'index.php';</script>";
    } else {
       
        $sql = "INSERT INTO records (volume, place_of_birth, notification_from, notification_to, entry_from, entry_to) 
                VALUES ('$volume', '$place_of_birth', '$notification_from', '$notification_to', '$entry_from', '$entry_to')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Record successfully added');</script>";
            echo "<script>window.location = 'index.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Civil Registry Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
        /* Fixed Header */
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: #dc3545; /* Red theme */
            padding: 15px 0;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Prevent content from being hidden behind fixed header */
        body {
            padding-top: 100px; /* Adjust to match header height */
        }

        /* Header container for alignment */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 15px;
        }

        .header-container img {
            height: 80px;
        }

        .header-container h1 {
            margin: 0;
            font-size: 24px;
            flex-grow: 1;
            text-align: center;
        }

        .header-container a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Fixed Header -->
    <header class="fixed-header text-white text-center">
        <div class="container header-container">
            <img src="IMAGES/download 12.png" alt="Logo">
            <h1>CIVIL REGISTRY</h1>
            <a href="login.php" onclick="return confirmLogout();">
                <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
            </a>
        </div>
    </header>

    <div class="container mt-4">
        <a href="CA.php" class="btn btn-outline-dark float-end">Go to CA</a>
        <h3 class="mb-3">Add New Record</h3>
        <form id="recordForm" method="post" class="p-4 border rounded bg-white">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="recordVOLUME" class="form-label">VOLUME</label>
                    <input type="text" id="recordVOLUME" name="recordVOLUME" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="recordBIRTH" class="form-label">PLACE OF BIRTH</label>
                    <input type="text" id="recordBIRTH" name="recordBIRTH" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="recordNOTIFICATION1" class="form-label">NOTIFICATION FROM</label>
                    <input type="text" id="recordNOTIFICATION1" name="recordNOTIFICATION1" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="recordNOTIFICATION2" class="form-label">NOTIFICATION TO</label>
                    <input type="text" id="recordNOTIFICATION2" name="recordNOTIFICATION2" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="recordENTRY1" class="form-label">ENTRY FROM</label>
                    <input type="text" id="recordENTRY1" name="recordENTRY1" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="recordENTRY2" class="form-label">ENTRY TO</label>
                    <input type="text" id="recordENTRY2" name="recordENTRY2" class="form-control">
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Add Record</button>
            </div>
        </form>

        <div class="text-center my-4">
            <input type="text" id="searchInput" class="form-control d-inline-block w-50" placeholder="Search..." oninput="searchRecords()">
            <button type="reset" id="resetButton" class="btn btn-primary">Get Records</button>
        </div>

        <table class="table table-bordered text-center bg-white">
            <thead class="table-dark">
                <tr>
                    <th>VOLUME</th>
                    <th>PLACE OF BIRTH</th>
                    <th>NOTIFICATION FROM</th>
                    <th>NOTIFICATION TO</th>
                    <th>ENTRY FROM</th>
                    <th>ENTRY TO</th>
                </tr>
            </thead>
            <tbody id="recordTable">
            </tbody>
        </table>
    </div>

    <script>
        function searchRecords() {
            var input = document.getElementById("searchInput").value.toUpperCase();
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    var records = JSON.parse(this.responseText);
                    updateTable(records);
                }
            };
            xhr.open("GET", "crb.php?q=" + input, true);
            xhr.send();
        }

        function updateTable(records) {
            var tableBody = document.getElementById("recordTable");
            tableBody.innerHTML = "";
            records.forEach(function (record) {
                var newRow = document.createElement("tr");
                newRow.innerHTML = "<td>" + record.volume + "</td>" +
                    "<td>" + record.place_of_birth + "</td>" +
                    "<td>" + record.notification_from + "</td>" +
                    "<td>" + record.notification_to + "</td>" +
                    "<td>" + record.entry_from + "</td>" +
                    "<td>" + record.entry_to + "</td>";
                tableBody.appendChild(newRow);
            });
        }

        document.getElementById("resetButton").addEventListener("click", function () {
            var searchTerm = document.getElementById("searchInput").value;
            searchRecords(searchTerm);
        });

        function confirmLogout() {
            return confirm("Are you sure you want to log out?");
        }
    </script>

</body>
</html>

