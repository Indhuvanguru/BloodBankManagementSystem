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
    <title>Donor Section</title>
</head>
<body background="https://static.vecteezy.com/system/resources/previews/007/849/061/original/world-blood-donor-background-free-vector.jpg">
    <div class="container">
        <h1>Donor Section</h1>
        <nav>
            <ul>
                <li><a href="donor_registration.php">Donor Registration</a></li>
                <li><a href="donor_list.php">Donor List</a></li>
                <li><a href="blood_stock.php">Blood Stock List</a></li>
                <li><a href="out_of_stock.php">Out Stock Blood List</a></li>
                <li><a href="ngo_management.php">NGO Management</a></li>
                <a href="logout.php" class="logout-button">Logout</a>

            </ul>
        </nav>
    </div>
</body>
</html>
