<?php
// design_specification.php

$host = 'localhost';  // Database host
$dbname = 'garmentorders';  // Database name
$username = 'root';  // Database username
$password = '';  // Database password

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if POST request is received
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get POST data
        $collar_types = isset($_POST['collar']) ? $_POST['collar'] : [];
        $buttons = isset($_POST['button']) ? $_POST['button'] : [];
        $quantities = isset($_POST['quantity']) ? $_POST['quantity'] : [];

        // Ensure required fields are not empty
        if (!empty($collar_types) && !empty($quantities)) {
            foreach ($collar_types as $index => $collar_type) {
                $button = isset($buttons[$index]) && $buttons[$index] === 'yes' ? 1 : 0;
                $qty = isset($quantities[$index]) ? filter_var($quantities[$index], FILTER_VALIDATE_INT) : 0;

                if ($collar_type && $qty !== false) {
                    // Insert into database
                    $stmt = $pdo->prepare("INSERT INTO design_specification (collar_type, button, qty) VALUES (:collar_type, :button, :qty)");
                    $stmt->bindParam(':collar_type', $collar_type);
                    $stmt->bindParam(':button', $button, PDO::PARAM_BOOL);
                    $stmt->bindParam(':qty', $qty, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }

            // Return success response
            echo json_encode(['success' => true, 'message' => 'Data inserted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid input data']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
