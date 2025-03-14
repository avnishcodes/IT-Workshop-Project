<?php
session_start(); // Start the session
error_reporting(E_ALL);
ini_set('display_errors', 1); // Enable error reporting

session_regenerate_id(true); // Regenerate session ID

// Unset all of the session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the homepage
header("Location: http://localhost/IT%20Workshop/Front-End/index.php");
exit(); // Stop further script execution
?>
