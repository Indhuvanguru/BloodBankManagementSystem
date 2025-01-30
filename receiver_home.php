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
    <title>Receiver Section</title>
    
</head>
<body background="https://static.vecteezy.com/system/resources/previews/007/849/061/original/world-blood-donor-background-free-vector.jpg">
    <div class="container">
        <h1>Receiver Section</h1>
        <nav>
            <ul>
                <li><a href="request_blood.php">Request for Blood</a></li>
                <li><a href="request_list.php">Request List</a></li>
                <li><a href="exchange_blood.php">Exchange Blood</a></li>
                <li><a href="exchange_list.php">Exchange List</a></li>
            </ul>
        </nav>
        <a href="home.php" class="home-button">Back to Home</a>
        <hr>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>
