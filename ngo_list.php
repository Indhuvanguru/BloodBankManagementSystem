<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Fetch all NGOs from the database
$sql = "SELECT * FROM ngos";
$result = $conn->query($sql);
$ngos = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $ngos[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>NGO List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9; /* Light background for the page */
            color: #333; /* Dark text color for readability */
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff; /* White background for the container */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px; /* Rounded corners */
        }
        h1 {
            color: #6c63ff; /* Title color */
            text-align: center; /* Center the title */
            margin-bottom: 20px; /* Spacing below the title */
        }
        table {
            width: 100%;
            border-collapse: collapse; /* Merge borders */
            margin: 20px 0; /* Spacing around the table */
        }
        table th, table td {
            padding: 12px; /* Padding inside table cells */
            text-align: left; /* Align text to the left */
            border-bottom: 1px solid #ddd; /* Bottom border for each cell */
        }
        table th {
            background-color: #6c63ff; /* Header background color */
            color: white; /* White text color for header */
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for even rows */
        }
        table tr:hover {
            background-color: #d1d1e0; /* Slightly darker gray on hover */
        }
        .no-data {
            text-align: center; /* Center the no data message */
            color: #555; /* Dark gray text for no data */
        }
        .link-box {
            text-align: center; /* Center the link box */
            margin-top: 20px; /* Space above the link box */
        }
        .link-box a {
            color: #6c63ff; /* Link color */
            text-decoration: none; /* Remove underline from link */
            font-weight: bold; /* Make the link bold */
        }
        .link-box a:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body background="https://static.vecteezy.com/system/resources/previews/007/849/061/original/world-blood-donor-background-free-vector.jpg">
    <div class="container">
        <h1>NGO List</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact Person</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ngos)): ?>
                    <?php foreach ($ngos as $ngo): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ngo['id']); ?></td>
                            <td><?php echo htmlspecialchars($ngo['name']); ?></td>
                            <td><?php echo htmlspecialchars($ngo['contact_person']); ?></td>
                            <td><?php echo htmlspecialchars($ngo['contact_number']); ?></td>
                            <td><?php echo htmlspecialchars($ngo['address']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="no-data">No NGOs found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="link-box">
            <p><a href="ngo_management.php">Back to NGO Management</a></p>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
