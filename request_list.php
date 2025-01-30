<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Fetch all requests from the blood_requests table
$sql = "SELECT * FROM blood_requests ORDER BY request_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Request List</title>
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body background="https://static.vecteezy.com/system/resources/previews/007/849/061/original/world-blood-donor-background-free-vector.jpg">
    <div class="container">
        <h1>Blood Request List</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Receiver Name</th>
                    <th>Blood Group</th>
                    <th>Contact</th>
                    <th>Quantity (ml)</th>
                    <th>Request Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['receiver_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['blood_group']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['request_date']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No requests found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="navigation-links">
            <a href="home.php" class="home-button">Back to Home</a>
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
