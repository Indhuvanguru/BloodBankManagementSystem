<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $blood_group = $_POST['blood_group'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $quantity = $_POST['quantity'];

    // Prepare and execute SQL statement to insert donor data
    $stmt = $conn->prepare("INSERT INTO donors (name, blood_group, contact, email, age, gender, address, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssissi", $name, $blood_group, $contact, $email, $age, $gender, $address, $quantity);
    $stmt->execute();
    $success = "Donor registered successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Donor Registration</title>
</head>
<body background="https://static.vecteezy.com/system/resources/previews/007/849/061/original/world-blood-donor-background-free-vector.jpg">
    <div class="container">
        <h1>Donor Registration Form</h1>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <form method="POST">
            <label for="name" style="text-align: left;">Name:</label>
            <input type="text" name="name" id="name" class="equal-box" required>

            <label for="blood_group">Blood Group:</label>
            <select name="blood_group" id="blood_group" class="equal-box" required>
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
            <input type="text" name="contact" id="contact" class="equal-box" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="equal-box" required>

            <label for="age">Age:</label>
            <input type="number" name="age" id="age" class="age-box" required>

            <label for="gender">Gender:</label>
            <select name="gender" id="gender" class="equal-box" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="address">Address:</label>
            <textarea name="address" id="address" class="equal-box" rows="3" required></textarea>

            

            <button type="submit" class="submit-button">Register</button>
        </form>

        <div class="link-box">
            <a href="donor_home.php" class="back-button">Back to Home</a>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
