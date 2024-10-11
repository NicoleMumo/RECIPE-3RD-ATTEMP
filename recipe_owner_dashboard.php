
<?php
session_start();
include 'database.php';

// Ensure only recipe owners can access this page
if ($_SESSION['role'] != 'recipe_owner') {
    header("Location: login.php"); // Redirect to login page if not logged in as a recipe owner
    exit();
}

// Handle delete recipe action
if (isset($_POST['delete_recipe'])) {
    $recipe_id = $_POST['recipe_id'];

    $delete_stmt = $conn->prepare("DELETE FROM recipes WHERE recipe_id = ?");
    $delete_stmt->bind_param("i", $recipe_id);

    if ($delete_stmt->execute()) {
        $success_message = "Recipe deleted successfully.";
        // Redirect or refresh to update the list
        header("Refresh:0");
        exit();
    } else {
        $error_message = "Error deleting recipe: " . $conn->error;
    }
}

// Handle edit recipe action
if (isset($_POST['edit_recipe'])) {
    $recipe_id = $_POST['recipe_id'];
    $ingredients = $_POST['ingredients'];
    $recipe_name = $_POST['recipe_name'];

    $edit_stmt = $conn->prepare("UPDATE recipes SET ingredients = ?, recipe_name = ? WHERE recipe_id = ?");
    $edit_stmt->bind_param("ssi", $ingredients, $recipe_name, $recipe_id);

    if ($edit_stmt->execute()) {
        $success_message = "Recipe updated successfully.";
        // Redirect or refresh to update the list
        header("Refresh:0");
        exit();
    } else {
        $error_message = "Error updating recipe: " . $conn->error;
    }
}

// Query to fetch recipes and user details added by the current recipe owner
$username = $_SESSION['username'];

// Fetch recipes
$sql_recipes = "SELECT * FROM recipes WHERE recipe_owner = ?";
$stmt_recipes = $conn->prepare($sql_recipes);
$stmt_recipes->bind_param("s", $username);
$stmt_recipes->execute();
$result_recipes = $stmt_recipes->get_result();

// Fetch user details (age and email)
$sql_user = "SELECT age, email FROM user WHERE username = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $username);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_details = $result_user->fetch_assoc();

$stmt_recipes->close();
$stmt_user->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Owner Dashboard</title>
    <link rel="stylesheet" href="recipe_owner_dashboard_style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
        
        <h3>User Details:</h3>
        <p><strong>Email:</strong> <?php echo $user_details['email']; ?></p>
        <p><strong>Age:</strong> <?php echo $user_details['age']; ?></p>

        <h3>Recipes Added by You:</h3>

        <?php if ($result_recipes->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Recipe ID</th>
                    <th>Recipe Image</th>
                    <th>Ingredients</th>
                    <th>Recipe Name</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result_recipes->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['recipe_id']; ?></td>
                        <td><img src="recipe_images/<?php echo $row['recipe_image']; ?>" alt="Recipe Image" style="max-width: 100px;"></td>
                        <td><?php echo $row['ingredients']; ?></td>
                        <td><?php echo $row['recipe_name']; ?></td>
                        <td>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <input type="hidden" name="recipe_id" value="<?php echo $row['recipe_id']; ?>">
                                <button type="submit" name="delete_recipe">Delete</button>
                            </form>
                            <button onclick="editRecipe(<?php echo $row['recipe_id']; ?>, '<?php echo $row['ingredients']; ?>', '<?php echo $row['recipe_name']; ?>')">Edit</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No recipes added yet.</p>
        <?php endif; ?>

        <div class="actions">
            <a href="add_recipe.php">Add Recipe</a>
            <a href="add_categories.php">Add Categories</a>
        </div>

        <div id="editForm" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEditForm()">&times;</span>
                <h2>Edit Recipe</h2>
                <form id="editRecipeForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" id="edit_recipe_id" name="recipe_id" value="">
                    <div class="form-group">
                        <label for="edit_ingredients">Ingredients:</label><br>
                        <textarea id="edit_ingredients" name="ingredients" rows="4" cols="50" required></textarea><br><br>
                    </div>
                    <div class="form-group">
                        <label for="edit_recipe_name">Recipe Name:</label><br>
                        <input type="text" id="edit_recipe_name" name="recipe_name" required><br><br>
                    </div>
                    <input type="submit" name="edit_recipe" value="Save Changes">
                </form>
            </div>
        </div>

        <div><?php echo isset($success_message) ? $success_message : ''; ?></div>
        <div><?php echo isset($error_message) ? $error_message : ''; ?></div>
    </div>

    <script>
        function editRecipe(id, ingredients, name) {
            document.getElementById('edit_recipe_id').value = id;
            document.getElementById('edit_ingredients').value = ingredients;
            document.getElementById('edit_recipe_name').value = name;
            document.getElementById('editForm').style.display = 'block';
        }

        function closeEditForm() {
            document.getElementById('editForm').style.display = 'none';
        }
    </script>
</body>
</html>
