<?php
session_start();
include 'connection2.php';  // Include database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize variables to store form data
    $product_type = "Kids T shirt"; // Set the product type, can be dynamic
    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL']; // Define sizes array
    $sleeve_types = ['full', 'half', 'sleeveless']; // Define sleeve types

    // Handle file upload
    $target_dir = "uploads/";
    $image = $_FILES['image']['name'];
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    // Capture session data
    $action_by = $_SESSION['username'];  // Assuming username is stored in session
    $customer_id = $_SESSION['customer_id']; // Assuming customer ID is in session

    // SQL to insert the basic order data into the `orders` table
    $sql = "INSERT INTO orders (product_type, image, action_by, customer_id) VALUES (?, ?, ?, ?)";
    
    // Prepare and bind
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssii", $product_type, $image, $action_by, $customer_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Get the inserted order_id
            $order_id = $conn->insert_id;

            // Store the order_id in the session for future use
            $_SESSION['order_id'] = $order_id;

            // Now insert size and sleeve data into the `order_details` table using the same `order_id`
            $sql_details = "INSERT INTO orders (order_id, size, sleeve_type, total_qty) VALUES (?, ?, ?, ?)";

            // Prepare the statement for inserting size and sleeve details
            if ($stmt_details = $conn->prepare($sql_details)) {
                // Loop through each size and sleeve type to get the quantities
                foreach ($sizes as $size) {
                    foreach ($sleeve_types as $sleeve) {
                        // Construct the form field name dynamically (e.g., 's_full', 's_half', 's_sleeveless')
                        $field_name = strtolower($size) . "_" . $sleeve;
                        if (isset($_POST[$field_name]) && $_POST[$field_name] > 0) {
                            $quantity = $_POST[$field_name];  // Get the quantity from form input
                            $sleeve_type = ucfirst($sleeve);  // Capitalize the first letter of the sleeve type
                            
                            // Bind parameters for each size and sleeve entry
                            $stmt_details->bind_param("issi", $order_id, $size, $sleeve_type, $quantity);

                            // Execute the insertion for each size and sleeve type
                            if (!$stmt_details->execute()) {
                                echo "Error: " . $stmt_details->error;
                            }
                        }
                    }
                }

                echo "Order submitted successfully!";
                $stmt_details->close();
            } else {
                echo "Error preparing the details statement: " . $conn->error;
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }
    
    // Close the database connection
    $conn->close();
}
?>
