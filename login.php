<?php
// Start the session
session_start();

// Initialize the error message variable
$error_message = '';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);

    // Simple validation for username
    if (!empty($username)) {
        $_SESSION['username'] = $username;
        $_SESSION['logged_in'] = true;
        header("Location: GarmentOrders.php");
        exit;
    } else {
        $error_message = "Please enter your name.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <style>
        .error { color: red; }
        body { font-family: Arial, sans-serif; }
    </style>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        <label for="username">Enter Name:</label>
        <input type="text" id="username" name="username" required><br><br>
        <button type="submit">Login</button>
    </form>
    <?php if (!empty($error_message)): ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
</body>
</html>
