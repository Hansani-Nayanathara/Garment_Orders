<?php

$SdbServerName = "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbName = "garmentcustomers";

// Create connection
$conn = new mysqli($SdbServerName, $dbUserName, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
