<?php
// Database configuration
$db_host = "localhost";
$db_name = "APITESTR";
$db_user = "api_user";
$db_password = "api_password";

// Establish a MySQLi connection
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Set character set for the connection
mysqli_set_charset($conn, 'utf8mb4');

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Close the connection
mysqli_close($conn);
?>