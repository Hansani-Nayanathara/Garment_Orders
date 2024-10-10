<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start(); // Ensure session is started at the top

    include 'Connection2.php';

    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $image = $targetFile;
    } else {
        $image = null;
    }

    $productType = $_POST['product_type'];
    $sleeveType = null;
    $description = "";

    $sizes = [];
    $totalQtys = [];
    $lengths = [];

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

    $jsonSizes = json_encode($sizes);
    $jsonQtys = json_encode($totalQtys);
    $jsonLengths = json_encode($lengths);

    if (isset($_SESSION['customer_id'])) {
        $customer_id = $_SESSION['customer_id'];
    } else {
        die("Error: customer_id not set in the session.");
    }

    if (isset($_SESSION['username'])) {
        $actionBy = $_SESSION['username'];
    } else {
        die("Error: username not set in the session.");
    }

    $stmt = $conn->prepare("INSERT INTO orders (product_type, size, sleeve_type, length, total_qty, image, description, action_by, customer_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssssssssi", $productType, $jsonSizes, $sleeveType, $jsonLengths, $jsonQtys, $image, $description, $actionBy, $customer_id);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Debug output to confirm order_id is retrieved
        echo "Order successfully inserted. Order ID: " . $order_id . "<br>";

        $_SESSION['order_id'] = $order_id;

        // Debug output to confirm session data
        echo "Order ID stored in session: " . $_SESSION['order_id'] . "<br>";
    } else {
        echo "Error storing data: " . $stmt->error . "<br>";
    }

    $stmt->close();
    $conn->close();

    // Temporarily comment out the redirect to view debug output
    // header("Location: success.php");
    exit();
}
?>
