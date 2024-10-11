<?php
include 'database.php';

$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipe_image_name = $_FILES['recipe_image']['name'];
    $recipe_image_temp = $_FILES['recipe_image']['tmp_name'];
    $ingredients = $_POST['ingredients'];
    $recipe_name = $_POST['recipe_name'];
    $recipe_owner = $_POST['recipe_owner'];

    // Set the directory to save recipe images
    $target_directory = "recipe_images/";
    $target_file = $target_directory . basename($recipe_image_name);

    // Move uploaded file to the target directory
    if (move_uploaded_file($recipe_image_temp, $target_file)) {
        // Prepare and execute SQL statement
        $stmt = $conn->prepare("INSERT INTO recipes (recipe_image, ingredients, recipe_name, recipe_owner) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $recipe_image_name, $ingredients, $recipe_name, $recipe_owner);

        // Check if insertion was successful
        if ($stmt->execute()) {
            $success_message = "The recipe has been added successfully";
            // Redirect to success page
            header("Location: success.php");
            exit();
        } else {
            $success_message = "Error adding recipe: " . $conn->error;
        }

        $stmt->close();
    } else {
        $success_message = "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    <link rel="stylesheet"  href ="add_recipe_style.css">
</head>

    <div class="picture-container">
        <img src="Image/FOOD5.jpg" alt="Picture 1">
        <img src="Image/FOOD3.jpg" alt="Picture 2">
        <img src="Image/FOOD1.jpg" alt="Picture 3">
    </div>
    <div class="logo">
            <img src="Image/cookingbook.png" alt="Logo">
        
          <h1> COOKING BOOK</h1>
         </div>
    <
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <div class="container">     
        <h1>ADD RECIPE</h1>
        <div class="recipe_image">
                <label for="recipe_image">Upload Recipe Image</label>
                <input type="file" id="recipe_image" name="recipe_image" accept="image/*" class="file-input">
            </div>
            <div class="form-group">
                <label for="ingredients">Ingredients:</label><br>
                <textarea id="ingredients" name="ingredients" rows="4" cols="50" required></textarea><br><br>
            </div>
            <div class="form-group">
                <label for="recipe_name">Recipe Name:</label><br>
                <input type="text" id="recipe_name" name="recipe_name" required><br><br>
            </div>
            <div class="form-group">
                <label for="recipe_owner">Recipe Owner:</label><br>
                <input type="text" id="recipe_owner" name="recipe_owner" required><br><br>
            </div>
            <input type="submit" value="Add Recipe">
        </form> 
    <div><?php echo $success_message; ?></div>
</body>
</html>

