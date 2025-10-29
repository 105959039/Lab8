<?php
session_start();
require_once "settings.php";

// Redirect to login if not authenticated
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get current user data
$username = $_SESSION['username'];
$sql = "SELECT * FROM user WHERE username = '$username'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Update session email
$_SESSION['email'] = $user['email'];

$success = isset($_GET['success']) ? $_GET['success'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Profile</title>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f0f2f5; }
        .profile-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto; }
        h1, h2 { color: #333; }
        .user-info { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .info-item { margin: 15px 0; padding: 10px; border-bottom: 1px solid #eee; }
        .info-label { font-weight: bold; color: #555; display: inline-block; width: 100px; }
        .edit-form { background: #e7f3ff; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input[type="email"] { width: 100%; padding: 10px; border: 2px solid #ddd; border-radius: 5px; font-size: 16px; box-sizing: border-box; }
        input[type="submit"] { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        input[type="submit"]:hover { background: #218838; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .logout { text-align: center; margin-top: 20px; }
        .logout-btn { background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; }
        .logout-btn:hover { background: #c82333; }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1>👤 My Profile</h1>
        
        <?php if ($success): ?>
            <div class="success">✅ Profile updated successfully!</div>
        <?php endif; ?>
        
        <div class="user-info">
            <h2>User Information</h2>
            <div class="info-item">
                <span class="info-label">Username:</span>
                <?php echo htmlspecialchars($user['username']); ?>
            </div>
            <div class="info-item">
                <span class="info-label">Student ID:</span>
                <?php echo htmlspecialchars($user['password']); ?>
            </div>
            <div class="info-item">
                <span class="info-label">Email:</span>
                <?php echo htmlspecialchars($user['email']); ?>
            </div>
        </div>
        
        <div class="edit-form">
            <h2>✏️ Edit Profile</h2>
            <form method="POST" action="update_profile.php">
                <div class="form-group">
                    <label for="email">Update Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <input type="submit" value="Update Email">
            </form>
        </div>
        
        <div class="logout">
            <a href="logout.php" class="logout-btn">🚪 Logout</a>
        </div>
    </div>
</body>
</html>