<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Define blood groups to check against the current stock
$blood_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

// Fetch blood stock and identify out-of-stock groups
$sql = "SELECT blood_group, SUM(quantity) AS total_quantity FROM donors GROUP BY blood_group";
$result = $conn->query($sql);

$stock = [];
while ($row = $result->fetch_assoc()) {
    $stock[$row['blood_group']] = $row['total_quantity'];
}

// Fill in stock for blood groups that are not in the database
foreach ($blood_groups as $group) {
    if (!isset($stock[$group])) {
        $stock[$group] = 0; // Set quantity to 0 for out-of-stock groups
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Out of Stock Blood List</title>
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
        <h1>Blood Stock List</h1>
        <table>
            <thead>
                <tr>
                    <th>Blood Group</th>
                    <th>Quantity (ml)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blood_groups as $group): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($group); ?></td>
                        <td><?php echo htmlspecialchars($stock[$group]); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (empty(array_filter($stock, fn($quantity) => $quantity > 0))): ?>
            <p class="no-data">All blood groups are out of stock.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
