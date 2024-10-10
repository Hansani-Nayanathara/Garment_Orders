<?php
session_start();

// Include the database connection file
include 'Connection.php';

// Initialize an error message variable
$error_message2 = '';

// Enable error reporting (useful for debugging, remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $mobile_number = $_POST['MobileNumber'];
    $name = $_POST['Name'];
    $address = $_POST['Address'];
    $delivery_date = $_POST['date'];
    
    // Get the username of the currently logged-in user
    if (isset($_SESSION['username'])) {
        $action_by = $_SESSION['username'];
    } else {
        $error_message2 = "User session not set.";
    }

    if (empty($error_message2)) {
        // Prepare SQL to check if the mobile number and action_by already exist
        $check_sql = "SELECT COUNT(*) as count FROM customers WHERE mobile_number = ? AND action_by = ?";
        $check_stmt = $conn->prepare($check_sql);
        if ($check_stmt === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        $check_stmt->bind_param("ss", $mobile_number, $action_by);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        if ($count > 0) {
            // If the count is greater than 0, the mobile number with the same user already exists
            $error_message2 = "This mobile number with user already exists in the database.";
        } else {
            // Prepare the SQL statement to insert data
            $sql = "INSERT INTO customers (mobile_number, name, address, delivery_date, action_by) VALUES (?, ?, ?, ?, ?)";

            // Prepare the SQL statement
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }

            // Bind the parameters
            if (!$stmt->bind_param("sssss", $mobile_number, $name, $address, $delivery_date, $action_by)) {
                die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
            }

            // Execute the statement within a try-catch block
            try {
                if (!$stmt->execute()) {
                    throw new mysqli_sql_exception($stmt->error, $stmt->errno);
                }

                // Get the ID of the newly inserted customer
                $customer_id = $stmt->insert_id;

                // Store customer_id in the session
                $_SESSION['customer_id'] = $customer_id;

            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() == 1062) { // 1062 is the error code for duplicate entry
                    $error_message2 = "This mobile number with user already exists in the database.";
                } else {
                    die("Execute failed: (" . $e->getCode() . ") " . $e->getMessage());
                }
            }

            // Close the statement
            $stmt->close();

            // If there is no error message, redirect to the order form page
            if (empty($error_message2)) {
                header("Location: GarmentOrders.php?success=1");
                exit;
            }
        }
    }

    // If there was an error, redirect back to the form with the error message
    header("Location: GarmentOrders.php?error_message2=" . urlencode($error_message2));
    exit;
}
?>
