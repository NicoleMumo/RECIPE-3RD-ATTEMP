<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

require_once "db.php"; // Database connection file

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$user_type = $_SESSION["user_type"];

// Display profile details based on user_type
if ($user_type == 'admin') {
    // Fetch all users for admin
    $query = "SELECT * FROM users";
    $stmt = $pdo->query($query);
    $users = $stmt->fetchAll();
} elseif ($user_type == 'recipe_owner') {
    // Fetch recipes for recipe_owner
    $query = "SELECT * FROM recipes WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $recipes = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
</head>
<body>
    <div style="float: right;">Logged in as: <?php echo $username; ?> | <a href="logout.php">Logout</a></div>
    <h2>Profile</h2>
    <?php if ($user_type == 'admin') { ?>
        <h3>All Users</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>User Type</th>
            </tr>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['user_type']; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } elseif ($user_type == 'recipe_owner') { ?>
        <h3>Your Recipes</h3>
        <ul>
            <?php foreach ($recipes as $recipe) { ?>
                <li><?php echo $recipe['title']; ?></li>
            <?php } ?>
        </ul>
        <a href="add_recipe.php">Add Recipe</a>
    <?php } ?>
</body>
</html>
