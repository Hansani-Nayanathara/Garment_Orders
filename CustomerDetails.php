<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session
session_start();

// Database connection
include 'Connection.php';

// Check if the request is for checking mobile number via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_mobile']) && isset($_POST['mobile_number'])) {
    // Handle AJAX request to check mobile number
    $mobile_number = $_POST['mobile_number'];

    // Prepare SQL to check if the mobile number exists
    $check_sql = "SELECT COUNT(*) as count FROM customers WHERE mobile_number = ?";
    $check_stmt = $conn->prepare($check_sql);

    if ($check_stmt === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $check_stmt->bind_param("s", $mobile_number);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    // Return response
    if ($count > 0) {
        echo 'exists';
    } else {
        echo 'not_exists';
    }

    exit; // End the script for AJAX request
}
?>
