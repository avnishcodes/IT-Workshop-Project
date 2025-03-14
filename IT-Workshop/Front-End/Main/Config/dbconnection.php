<?php
// Database connection
$host = 'localhost';
$db = 'e-library';
$user = 'root'; // Your MySQL username
$pass = '';     // Your MySQL password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>