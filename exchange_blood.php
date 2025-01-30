<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $requested_blood_group = $_POST['requested_blood_group'];
    $offered_blood_group = $_POST['offered_blood_group'];
    $donor_id = $_POST['donor_id']; 
    $exchange_quantity = $_POST['exchange_quantity']; // Quantity requested for exchange

    // Check donor availability for the requested blood group and quantity
    $stmt = $conn->prepare("SELECT quantity FROM donors WHERE id = ? AND blood_group = ? AND quantity >= ?");
    $stmt->bind_param("isi", $donor_id, $requested_blood_group, $exchange_quantity);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Donor has enough quantity; proceed with exchange
        $donor = $result->fetch_assoc();
        $new_quantity = $donor['quantity'] - $exchange_quantity;

        // Insert the request into the blood_exchange table with offered and requested blood groups
        $stmt = $conn->prepare("INSERT INTO blood_exchange (requested_blood_group, offered_blood_group, donor_id, quantity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $requested_blood_group, $offered_blood_group, $donor_id, $exchange_quantity);
        $stmt->execute();

        // Update donor's quantity in the donors table
        $stmt = $conn->prepare("UPDATE donors SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $new_quantity, $donor_id);
        $stmt->execute();

        $success = "Blood exchange request submitted successfully!";
    } else {
        // Not enough blood available for the requested quantity
        $error = "Insufficient blood quantity available for this blood group and donor.";
    }
}

// Fetch available donors with sufficient blood stock
$sql = "SELECT id, name, blood_group, quantity FROM donors WHERE quantity > 0";
$result = $conn->query($sql);
$donors = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $donors[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Exchange Blood</title>
    <style>
        .container {
            width: 60%;
            margin: 0 auto;
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        .success {
            color: #28a745;
            text-align: center;
        }
        .error {
            color: #dc3545;
            text-align: center;
        }
    </style>
</head>
<body background="https://static.vecteezy.com/system/resources/previews/007/849/061/original/world-blood-donor-background-free-vector.jpg">
    <div class="container">
        <h1>Exchange Blood</h1>

        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST">
            <label for="requested_blood_group">Requested Blood Group:</label>
            <select name="requested_blood_group" id="requested_blood_group" required>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>

            <label for="offered_blood_group"> Blood Group for Exchange:</label>
            <select name="offered_blood_group" id="offered_blood_group" required>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>

            <label for="donor_id">Select Donor:</label>
            <select name="donor_id" id="donor_id" required>
                <?php foreach ($donors as $donor): ?>
                    <option value="<?php echo htmlspecialchars($donor['id']); ?>">
                        <?php echo htmlspecialchars($donor['name'] . " (" . $donor['blood_group'] . ", Available: " . $donor['quantity'] . " ml)"); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="exchange_quantity">Quantity for Exchange (ml):</label>
            <input type="number" name="exchange_quantity" id="exchange_quantity" required min="1">

            <button type="submit">Request Exchange</button>
            <a href="home.php" class="home-button">Back to Home</a>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
