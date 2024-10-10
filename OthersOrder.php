<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Start the session
    session_start();

    // Database connection
    include 'Connection2.php';

    // Handle image upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $image = $targetFile;
    } else {
        $image = null;
    }

    // Collect form data
    $productType = "Others";  // Fixed category for "Others"
    $size = $_POST['size'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    // Get the customer_id from the session
    if (isset($_SESSION['customer_id'])) {
        $customer_id = $_SESSION['customer_id'];
    } else {
        die("Error: customer_id not set in the session.");
    }

    // Get the currently logged-in user's username
    if (isset($_SESSION['username'])) {
        $actionBy = $_SESSION['username'];
    } else {
        die("Error: username not set in the session.");
    }

    // Prepare and bind the statement for inserting order data
    $stmt = $conn->prepare("INSERT INTO orders (product_type, size, Other_type, total_qty, image, description, action_by, customer_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("sssssssi", $productType, $size, $type, $quantity, $image, $description, $actionBy, $customer_id);

    // Execute the statement to insert the data
    if ($stmt->execute()) {
        // Get the last inserted order_id
        $order_id = $stmt->insert_id;

        // Store the order_id in a session variable
        $_SESSION['order_id'] = $order_id;
    } else {
        echo "Error storing data: " . $stmt->error . "<br>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to a confirmation page
    header("Location: order_confirmation.php");
    exit();
}
