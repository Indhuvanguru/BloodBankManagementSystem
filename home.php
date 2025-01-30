<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Blood Bank Management System</title>
</head>
<body background="https://static.vecteezy.com/system/resources/previews/007/849/061/original/world-blood-donor-background-free-vector.jpg">
    <div class="container">
        <h1>Welcome to Blood Bank Management System</h1>
        <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <nav>
            <ul>
                <li><a href="donor_home.php">Donor Section</a></li>
                <li><a href="receiver_home.php">Receiver Section</a></li>
                <a href="logout.php" class="logout-button">Logout</a>

            </ul>
        </nav>
    </div>
</body>
</html>
