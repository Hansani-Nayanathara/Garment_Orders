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
    $productType = $_POST['product_type'];
    $sleeveType = null;
    $description = "";

    // Initialize arrays to store valid data
    $sizes = [];
    $totalQtys = [];
    $lengths = [];

    // Filter and collect sizes, quantities, and lengths
    foreach ($_POST['total_qty'] as $size => $totalQty) {
        $length = $_POST['length'][$size] ?? null;
        if (!empty($totalQty) && !empty($length)) {
            $sizes[] = $size;
            $totalQtys[] = $totalQty;
            $lengths[] = $length;
        }
    }

    if (empty($sizes) || empty($totalQtys) || empty($lengths)) {
        die("Error: No valid sizes, lengths, or total quantities were provided.");
    }

    // Use JSON to store arrays
    $jsonSizes = json_encode($sizes);
    $jsonQtys = json_encode($totalQtys);
    $jsonLengths = json_encode($lengths);

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
    $stmt = $conn->prepare("INSERT INTO orders (product_type, size, sleeve_type, length, total_qty, image, description, action_by, customer_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("ssssssssi", $productType, $jsonSizes, $sleeveType, $jsonLengths, $jsonQtys, $image, $description, $actionBy, $customer_id);

    // Execute the statement to insert the data
    if ($stmt->execute()) {
        // Get the last inserted order_id
        $order_id = $stmt->insert_id;
        
        // Debug: Output order_id to verify
        echo "Order ID: " . $order_id . " generated.<br>";
        
        // Store the order_id in a session variable
        $_SESSION['order_id'] = $order_id;

        // Debug: Check if session is correctly set
        if (isset($_SESSION['order_id'])) {
            echo "Order ID: " . $_SESSION['order_id'] . " has been successfully stored in the session.<br>";
        } else {
            echo "Error: Order ID not stored in the session.<br>";
        }
    } else {
        echo "Error storing data: " . $stmt->error . "<br>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to success page (add a delay to allow echo output)
    header("refresh:3; url=success.php");
    exit();
}
?>
