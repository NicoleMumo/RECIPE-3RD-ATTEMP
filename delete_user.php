<?php
// Include database connection
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // SQL query to delete user
    $sql = "DELETE FROM user WHERE `User-id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Redirect back to display users page after successful deletion
        header("Location: display_users.php");
        exit();
    } else {
        echo "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: display_users.php");
    exit();
}
?>
