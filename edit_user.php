<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 10px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .submit-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        .submit-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php
// Include database connection
require 'database.php';

// Initialize variables for form fields
$user_id = $username = $age = $email = "";

// Check if ID parameter is passed in URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // SQL query to retrieve user data based on ID
    $sql = "SELECT * FROM user WHERE `User-id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        $username = $row['Username'];
        $age = $row['Age'];
        $email = $row['Email'];
    } else {
        echo "User not found.";
        exit();
    }

    $stmt->close();
}

// Check if form is submitted for updating user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $user_id = $_POST['user_id'];
    $username = htmlspecialchars($_POST['username']);
    $age = intval($_POST['age']);
    $email = htmlspecialchars($_POST['email']);

    // SQL query to update user information
    $sql = "UPDATE user SET Username = ?, Age = ?, Email = ? WHERE `User-id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $username, $age, $email, $user_id);

    if ($stmt->execute()) {
        // Redirect back to display users page after successful update
        header("Location: display_users.php");
        exit();
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<div class="container">
    <h2>Edit User</h2>
    <form method="post">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
        </div>
        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" id="age" name="age" value="<?php echo $age; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>
        <button type="submit" class="submit-button">Update</button>
    </form>
</div>

</body>
</html>
