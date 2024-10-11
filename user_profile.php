<?php
session_start();

// Check if user is authenticated and is a Recipe Owner
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'recipe_owner') {
    header("Location: index.html");
    exit();
}

// Fetch additional user details from the database (if needed)
include 'database.php';

$username = $_SESSION['username'];

// Query to fetch user-specific data, e.g., recipes, categories
// Adjust SQL query as per your database structure
$sql = "SELECT * FROM recipes WHERE recipe_owner = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style> /* CSS styling as per your provided example */ </style>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>

    <!-- Display user-specific details, e.g., recipes and categories -->
    <h3>Recipes by <?php echo $_SESSION['username']; ?></h3>
    <ul>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . $row['recipe_name'] . "</li>";
        }
        ?>
    </ul>

    <a href="index.html">Go to Homepage</a>

    <!-- Add other elements and functionality as needed -->
</body>
</html>
