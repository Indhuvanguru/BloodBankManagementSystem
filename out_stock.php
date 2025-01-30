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

$in_stock = [];
while ($row = $result->fetch_assoc()) {
    if ($row['total_quantity'] > 0) {
        $in_stock[] = $row['blood_group'];
    }
}

// Calculate out-of-stock groups by excluding in-stock groups from the list
$out_of_stock = array_diff($blood_groups, $in_stock);
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
<body>
    <div class="container">
        <h1>Out of Stock Blood List</h1>
        <?php if (!empty($out_of_stock)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Blood Group</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($out_of_stock as $blood_group): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($blood_group); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">All blood groups are in stock.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
