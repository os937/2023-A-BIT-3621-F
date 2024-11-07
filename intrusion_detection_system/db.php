<?php
$host = 'localhost';
$db = 'ids_system';
$user = 'root'; // Replace with your database username
$pass = ''; // Replace with your database password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>

