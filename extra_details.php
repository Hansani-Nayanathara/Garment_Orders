<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Start the session
    session_start();

    // Database connection
    include 'Connection2.php';

    // Get the order_id from the session
    if (isset($_SESSION['order_id'])) {
        $order_id = $_SESSION['order_id'];
    } else {
        die("Error: order_id not set in the session.");
    }

    // Get the need_bottoms value from the form
    $need_bottoms = isset($_POST['need_bottoms']) ? $_POST['need_bottoms'] : 'no';

    // Prepare the statement for inserting into the extra_details table
    $stmt = $conn->prepare("INSERT INTO extra_details (order_id, need_bottoms, name, number, size, sleeve_type) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Loop through each row of the table and insert the data
    $rowCount = count($_POST['name']);  // Count based on number of name inputs (all arrays have same length)
    for ($i = 0; $i < $rowCount; $i++) {
        $name = $_POST['name'][$i];
        $number = $_POST['number'][$i];
        $size = $_POST['size'][$i];
        $sleeveType = $_POST['sleeve'][$i];

        // Bind the parameters
        $stmt->bind_param("isssss", $order_id, $need_bottoms, $name, $number, $size, $sleeveType);

        // Execute the statement
        if (!$stmt->execute()) {
            echo "Error storing data: " . $stmt->error . "<br>";
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect or output success message
    header("Location: success.php");
    exit();
}
?>
