<?php
// Start session (if not already started)
session_start();

// Check if the user is logged in
// Redirect to login page if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Assuming you have a database connection established
// Replace with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipedatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch recipes with image data
$sql = "SELECT recipe_id, recipe_owner, recipe_name, recipe_image FROM recipes";
$result = $conn->query($sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Images</title>
    <style>
        .recipe {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px; /* Adjust width as needed */
        }
        .recipe p {
            margin: 5px 0;
        }
        .recipe-image {
            width: 150px;
            height: 150px;
            overflow: hidden; /* Ensures the image does not overflow the dimensions */
        }
        .recipe-image img {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
</head>
<body>

<h2>Recipes</h2>

<?php
// Check if there are any recipes
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo '<div class="recipe">';
        echo '<p>Recipe ID: ' . htmlspecialchars($row["recipe_id"]) . '</p>';
        echo '<p>Owner: ' . htmlspecialchars($row["recipe_owner"]) . '</p>';
        echo '<p>Name: ' . htmlspecialchars($row["recipe_name"]) . '</p>';

        // Check if recipe_image file exists in recipe_images directory
        $image_path = "recipe_images/" . htmlspecialchars($row["recipe_image"]);
        if (file_exists($image_path)) {
            echo '<div class="recipe-image"><img src="' . $image_path . '" alt="Recipe Image"></div>';
        } else {
            echo "<p>No image available</p>";
        }

        echo '</div>';
    }
} else {
    echo "<p>No recipes found.</p>";
}
?>

</body>
</html>

