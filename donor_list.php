<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Fetch all donors from the database
$sql = "SELECT * FROM donors";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Donor List</title>
    <style>
       body {
    background-color: transparent; /* or just remove this line */
        }

        /* For a specific container */
        .container {
         background-color: transparent; /* or just remove this line */
        }

        
        h1 {
            color: #6c63ff; /* Title color */
            text-align: center; /* Center the title */
            margin-bottom: 20px; /* Spacing below the title */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1em;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #6c63ff; /* Header background color */
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for even rows */
        }
        table tr:hover {
            background-color: #d1d1e0; /* Slightly darker gray on hover */
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
        <h1>Donor List</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Blood Group</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Quantity (ml)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['blood_group']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['age']); ?></td>
                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">No donors have registered yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
