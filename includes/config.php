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

/*
// Test: test connection with a simple query
$sql = "SELECT * FROM items";
$result = mysqli_query($conn, $sql);

// Check if there are any results
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . "<br>";
        echo "items found in the database.";
    }
} else {
    echo "No items found in the database.";
}

// Check the query result
if ($result) {
    echo "MySQL connection is working.";
} else {
    echo "MySQL connection error: " . mysqli_error($conn);
}
*/

// Close the connection
mysqli_close($conn);
?>