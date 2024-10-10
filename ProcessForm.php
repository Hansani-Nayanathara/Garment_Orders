<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session
session_start();

// Database connection
include 'Connection.php';

// Initialize variables
$invoice_details = [];
$customer_details = [];
$error_message = '';

// Handle invoice search
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_invoice'])) {
    $invoice_number = trim($_POST['invoice_number']);

    if (empty($invoice_number)) {
        $error_message = "Invoice number is required.";
    } else {
        // Prepare SQL to fetch invoice details
        $invoice_sql = "SELECT * FROM invoice WHERE invoice_number = ?";
        $invoice_stmt = $conn->prepare($invoice_sql);

        if ($invoice_stmt === false) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        $invoice_stmt->bind_param("s", $invoice_number);
        $invoice_stmt->execute();
        $invoice_result = $invoice_stmt->get_result();

        if ($invoice_result->num_rows > 0) {
            $invoice_details = $invoice_result->fetch_assoc();
            $customer_id = $invoice_details['customer_id'];

            // Prepare SQL to fetch customer details
            $customer_sql = "SELECT * FROM customers WHERE customer_id = ?";
            $customer_stmt = $conn->prepare($customer_sql);

            if ($customer_stmt === false) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }

            $customer_stmt->bind_param("i", $customer_id);
            $customer_stmt->execute();
            $customer_result = $customer_stmt->get_result();

            if ($customer_result->num_rows > 0) {
                $customer_details = $customer_result->fetch_assoc();
            } else {
                $error_message = "Customer details not found.";
            }

            // Close customer statement
            $customer_stmt->close();
        } else {
            $error_message = "Invoice not found.";
        }

        // Close invoice statement
        $invoice_stmt->close();
    }

    // Store results in session
    $_SESSION['invoice_details'] = $invoice_details;
    $_SESSION['customer_details'] = $customer_details;
    $_SESSION['error_message'] = $error_message;

    // Redirect back to GarmentOrders.php
    header("Location: GarmentOrders.php");
    exit;
}
?>

