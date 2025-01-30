<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Fetch blood stock from the database
$sql = "SELECT blood_group, SUM(quantity) AS total_quantity FROM donors GROUP BY blood_group";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Blood Stock</title>
    <style>
        .container {
            width: 60%;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1em;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table th, table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #e74c3c;
            color: white;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            font-size: 1.2em;
            color: #555;
        }
    </style>
</head>
<body background="https://static.vecteezy.com/system/resources/previews/007/849/061/original/world-blood-donor-background-free-vector.jpg">
    <div class="container">
        <h1>Blood Stock</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Blood Group</th>
                        <th>Total Quantity (ml)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['blood_group']); ?></td>
                            <td><?php echo htmlspecialchars($row['total_quantity']); ?> ml</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">No blood stock available at the moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
