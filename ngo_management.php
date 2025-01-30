<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Handle form submission for adding NGOs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $contact_person = $_POST['contact_person'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];

    // Prepare and execute the insert statement
    $stmt = $conn->prepare("INSERT INTO ngos (name, contact_person, contact_number, address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $contact_person, $contact_number, $address);
    if ($stmt->execute()) {
        $success = "NGO added successfully!";
    } else {
        $error = "Failed to add NGO.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>NGO Management</title>
</head>
<body background="https://static.vecteezy.com/system/resources/previews/007/849/061/original/world-blood-donor-background-free-vector.jpg">
    <div class="container">
        <h1>NGO Management</h1>

        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="POST">
            <label for="name">NGO Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="contact_person">Contact Person:</label>
            <input type="text" name="contact_person" id="contact_person" required>

            <label for="contact_number">Contact Number:</label>
            <input type="text" name="contact_number" id="contact_number" required>

            <label for="address">Address:</label>
            <textarea name="address" id="address" rows="3" required></textarea>

            <button type="submit">Add NGO</button>
        </form>

        <div class="link-box">
            <p><a href="ngo_list.php">View NGO List</a></p>
            <p><a href="home.php">Back to Home</a></p> <!-- Back to Home button -->
            <a href="logout.php" class="logout-button">Logout</a>

        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
