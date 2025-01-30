<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Username already exists!";
    } else {
        // Prepare and execute the insert statement
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            $success = "Account created successfully! You can now log in.";
        } else {
            $error = "Failed to create account. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Sign Up</title>
</head>
<body background="https://static.vecteezy.com/system/resources/previews/007/849/061/original/world-blood-donor-background-free-vector.jpg">
    <div class="signup-form">
        <h2>Sign Up</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        </form>
        <p>Already have an account? <a href="login.php">Log in here</a></p> <!-- Login link -->
    </div>
</body>
</html>
