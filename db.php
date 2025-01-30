<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_bank";
$port = 3307;

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "";
}
?>

