<?php
session_start();
require_once "settings.php";

// Redirect to login if not authenticated
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Update email in database
    $sql = "UPDATE user SET email = '$new_email' WHERE username = '$username'";
    
    if (mysqli_query($conn, $sql)) {
        // Update session variable
        $_SESSION['email'] = $new_email;
        header("Location: profile.php?success=1");
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
} else {
    header("Location: profile.php");
    exit();
}
?>