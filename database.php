<?php
$host = "localhost"; // This should be the MySQL server address
$dbname = "recipedatabase"; // Database name
$username = "root"; // MySQL username
$password = ""; // MySQL password

// Establish a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

