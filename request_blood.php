<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receiver_name = $_POST['receiver_name'];
    $blood_group = $_POST['blood_group'];
    $contact = $_POST['contact'];
    $quantity = $_POST['quantity'];

    // Check if enough quantity is available in the donor stock for the requested blood group
    $stmt = $conn->prepare("SELECT id, quantity FROM donors WHERE blood_group = ? AND quantity >= ? LIMIT 1");
    $stmt->bind_param("si", $blood_group, $quantity);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Blood is available; process the request
        $donor = $result->fetch_assoc();
        $donor_id = $donor['id'];
        $new_quantity = $donor['quantity'] - $quantity;

        // Insert the request into the blood_requests table
        $stmt = $conn->prepare("INSERT INTO blood_requests (receiver_name, blood_group, contact, quantity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $receiver_name, $blood_group, $contact, $quantity);
        $stmt->execute();

        // Update the donor's quantity in the donors table
        $stmt = $conn->prepare("UPDATE donors SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $new_quantity, $donor_id);
        $stmt->execute();

        $success = "Blood request submitted successfully!";
    } else {
        // Not enough blood available
        $error = "Sorry, the requested quantity is not available for the selected blood group.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Request Blood</title>
</head>
<body background="https://static.vecteezy.com/system/resources/previews/007/849/061/original/world-blood-donor-background-free-vector.jpg">
    <div class="container">
        <h1>Blood Request Form</h1>
        <?php 
        if (isset($success)) echo "<p class='success'>$success</p>"; 
        if (isset($error)) echo "<p class='error'>$error</p>";
        ?>
        <form method="POST">
            <label for="receiver_name">Receiver Name:</label>
            <input type="text" name="receiver_name" id="receiver_name" required>

            <label for="blood_group">Blood Group:</label>
            <select name="blood_group" id="blood_group" required>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>

            <label for="contact">Contact:</label>
            <input type="text" name="contact" id="contact" required>

            <label for="quantity">Quantity (ml):</label>
            <input type="number" name="quantity" id="quantity" required>

            <button type="submit">Submit Request</button>
        </form>

        <div class="navigation-links">
            <a href="receiver_home.php" class="back-button">Back to Receiver Section</a>
            <a href="home.php" class="home-button">Back to Home</a>
            <hr><a href="logout.php" class="logout-button">Logout</a>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>

