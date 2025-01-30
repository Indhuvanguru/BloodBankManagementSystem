<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Fetch all blood exchange requests
$sql = "SELECT be.id, be.requested_blood_group, be.offered_blood_group, d.name AS donor_name, 
               be.quantity, be.request_date 
        FROM blood_exchange be 
        JOIN donors d ON be.donor_id = d.id 
        ORDER BY be.request_date DESC";

$result = $conn->query($sql);
$exchanges = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $exchanges[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Blood Exchange List</title>
    
</head>
<body background="https://static.vecteezy.com/system/resources/previews/007/849/061/original/world-blood-donor-background-free-vector.jpg">
    <div class="container">
        <h1>Blood Exchange List</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Requested Blood Group</th>
                    <th>Offered Blood Group</th>
                    <th>Donor Name</th>
                    <th>Quantity (ml)</th>
                    <th>Request Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($exchanges)): ?>
                    <tr>
                        <td colspan="6">No exchange requests found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($exchanges as $exchange): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($exchange['id']); ?></td>
                            <td><?php echo htmlspecialchars($exchange['requested_blood_group']); ?></td>
                            <td><?php echo htmlspecialchars($exchange['offered_blood_group']); ?></td>
                            <td><?php echo htmlspecialchars($exchange['donor_name']); ?></td>
                            <td><?php echo htmlspecialchars($exchange['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($exchange['request_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="home.php" class="home-button">Back to Home</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
