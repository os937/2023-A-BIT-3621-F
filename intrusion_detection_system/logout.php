<?php
session_start();
include 'db.php'; // Database connection file

// Log the logout activity
if (isset($_SESSION['user'])) {
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $username = $_SESSION['user'];
    $stmt = $conn->prepare('INSERT INTO logs (ip_address, activity_type, description) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $ip_address, 'Logout', "$username logged out.");
    $stmt->execute();
}

session_destroy();
header('Location: login.php');
exit();
?>
