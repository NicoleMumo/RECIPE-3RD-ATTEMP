<?php
// Include the database connection file
require 'database.php';

// Fetch all recipes from the database
$sql="SELECT User-id,Username,Age,Email FROM user ";
$result = $conn->query("$conn,$sql ");



// Close database connection
$conn->close();
?>
