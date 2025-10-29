<?php
session_start();
require_once "settings.php";

if (isset($_SESSION['username'])) {
    header("Location: profile.php");
    exit();
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Simple password check (in real project, use password_verify() with hashed passwords)
        if ($password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            header("Location: profile.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - Profile System</title>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f0f2f5; }
        .login-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 400px; margin: 0 auto; }
        h2 { text-align: center; color: #333; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 5px; font-size: 16px; box-sizing: border-box; }
        input[type="submit"] { background: #007bff; color: white; padding: 12px 30px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; width: 100%; }
        input[type="submit"]:hover { background: #0056b3; }
        .error { color: #dc3545; text-align: center; margin: 15px 0; }
        .demo-info { background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 20px 0; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>🔐 User Login</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="demo-info">
            <strong>Demo Credentials:</strong><br>
            Username: <strong>Shariar Oasib Shikto</strong><br>
            Password: <strong>125478Sh?</strong>
        </div>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>