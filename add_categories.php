<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe Category</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f8f8f8;
    color: #333;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 20px auto;
}

h2 {
    font-size: 24px;
    color: #555;
    margin-bottom: 20px;
    padding-left: 20px;
}

h3{
    color: #555;
    margin-bottom: 20px;
    padding-left: 20px;
}
form {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

form label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

form input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 20px;
}

form input[type="submit"] {
    background-color: #ff9800;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form input[type="submit"]:hover {
    background-color: #f57c00;
}

ul {
    list-style: none;
    padding-left: 20px;
}

ul li {
    margin-bottom: 10px;
}

.error-message {
    color: #f44336;
}

.success-message {
    color: #4caf50;
}

    </style>
   
</head>
<body>
    <h2>Add Recipe Category</h2>
    <form action="add_categories.php" method="post">
        <label for="category">Recipe Category:</label>
        <input type="text" id="category" name="category" required><br><br>
        <input type="submit" value="Submit">
    </form>

    <!-- List of categories -->
    <h3>Categories Added:</h3>
    <ul>
        <?php
        // Include the database connection file
        require_once 'database.php';

        // Fetch and display categories from the database
        $result = $conn->query("SELECT recipe_category FROM category");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['recipe_category'] . "</li>";
            }
        } else {
            echo "<li>No categories added yet.</li>";
        }
        ?>
    </ul>

   
    <?php
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Convert entered category to lowercase
        $recipe_category = strtolower($_POST['category']);
        
        // Check if the category already exists in lowercase
        $stmt = $conn->prepare("SELECT recipe_category FROM category WHERE LOWER(recipe_category) = ?");
        $stmt->bind_param("s", $recipe_category_lowercase);
        $recipe_category_lowercase = $recipe_category;
        $stmt->execute();
        $stmt->store_result();

        // If category already exists, display error message
        if ($stmt->num_rows > 0) {
            echo "<p>Category already exists!</p>";
        } else {
            // Prepare and bind the SQL statement to insert category
            $stmt = $conn->prepare("INSERT INTO category (recipe_category) VALUES (?)");
            $stmt->bind_param("s", $recipe_category);
            $stmt->execute();
    
            // Close statement
            $stmt->close();
    
            // Redirect to a new page
            header("Location: success_page.php");
            exit();
        }
    }
    ?>

</body>
</html>
