<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Registration_style.css">
</head>
<body>

<div class="container">
    <div class="logo">
        <img src="Image/cookingbook.png" alt="Logo">
        <h1>COOKING BOOK</h1>
    </div>
    <div class="side-image">
        <img src="Image/side-image.jpg" alt="side-image">
    </div>
    <section class="content">
        <form action="Registration.php" method="post" enctype="multipart/form-data" class="signup-form">
            <div class="form-group">
                <label for="name">Username</label>
                <input type="text" id="name" name="name" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" class="input-field" required>
                    <option value="user">User</option>
                    <option value="recipe_owner">Recipe Owner</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="profile">
                <label for="profile_pic">Upload Profile Picture</label>
                <input type="file" id="profile_pic" name="profile_pic" accept="image/*" class="file-input" required>
            </div>
            <button type="submit" class="submit-button">Submit</button>
        </form>
    </section>
</div>

<?php
// Include database connection
require_once 'database.php';

// Function to safely escape input
function sanitize($conn, $input) {
    return htmlspecialchars(mysqli_real_escape_string($conn, $input));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    $name = sanitize($conn, $_POST["name"]);
    $age = intval($_POST["age"]);
    $email = sanitize($conn, $_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $role = sanitize($conn, $_POST["role"]);

    // Validate name
    if (empty($name)) {
        die("Username is required");
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Enter a valid email");
    }

    // Validate password
    if (strlen($password) < 8) {
        die("Password must be at least 8 characters long");
    }
    if (!preg_match("/[a-z]/i", $password)) {
        die("Password must contain at least one letter");
    }
    if (!preg_match("/[0-9]/", $password)) {
        die("Password must contain at least one number");
    }
    if ($password !== $confirm_password) {
        die("Passwords do not match");
    }

    // Validate age
    if ($age < 12 || $age > 120) {
        die("Age must be between 12 and 120");
    }

    // Handle profile picture upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image
    $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    // Check file size
    if ($_FILES["profile_pic"]["size"] > 5000000) {
        die("Sorry, your file is too large.");
    }

    // Allow certain file formats
    $allowed_formats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_formats)) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Move uploaded file to target location
    if (!move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        die("Sorry, there was an error uploading your file.");
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_sql = "SELECT COUNT(*) AS count FROM user WHERE Email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $row = $check_result->fetch_assoc();

    if ($row['count'] > 0) {
        die("Email already exists. Please use a different email address.");
    }

    // Insert user details into database
    $sql = "INSERT INTO user (Username, Age, Email, Password, password_hash, Image, Role) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL error detected: " . $conn->error);
    }
    $stmt->bind_param("sisssss",
        $name,
        $age,
        $email,
        $password, // Plain password (not hashed)
        $password_hash,
        $target_file,
        $role
    );
    if (!$stmt->execute()) {
        die("Error inserting data: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
    echo "You have signed up successfully";
}
?>


</body>
</html>
