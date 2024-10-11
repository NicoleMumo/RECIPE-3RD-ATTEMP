<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <form action="login_process.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            
            <input type="submit" value="Login">
        </form>

        <div class="forgot-password">
            <a href="#">Forgot password?</a>
        </div>

        <div class="register-now">
            <p>Don't have an account? <a href="Registration.php">Register now</a></p>
        </div>
        
        <div class="footer">
            &copy; 2024 Cooking Book. All rights reserved.
        </div>
    </div>
</body>
</html>
