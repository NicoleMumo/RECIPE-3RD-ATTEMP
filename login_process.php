<!-- login_process.php -->

<?php
session_start();
include 'database.php'; // Assuming this file connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate user credentials
    $stmt = $conn->prepare("SELECT * FROM user WHERE Username = ? AND Password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['Username'];
        $_SESSION['role'] = $row['Role']; // Assuming 'Role' column in your users table

        // Redirect based on user role
        switch ($_SESSION['role']) {
            case 'user':
                header("Location: Index.php?username=" . urlencode($_SESSION['username']));
                break;
            case 'recipe_owner':
                header("Location: recipe_owner_dashboard.php");
                break;
            case 'admin':
                header("Location: display_users.php");
                break;
            default:
                // Handle any other roles as needed
                break;
        }
        exit();
    } else {
        // Invalid credentials handling
        header("Location: login.php?error=1"); // Redirect to login page with error flag
        exit();
    }

    $stmt->close();
}

$conn->close();
?>


