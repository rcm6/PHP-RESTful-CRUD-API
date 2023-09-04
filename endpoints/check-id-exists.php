<?php
// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Include database config
include_once './includes/config.php';

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to check if an item with the specified ID exists
function checkIdExists($conn, $id) {

    // Check if an item with the specified ID exists in the database
    $sql = "SELECT COUNT(*) FROM items WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $count);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            return $count > 0; // Return true if the ID exists, false otherwise
        } else {
            return false; // Query execution failed
        }
    } else {
        return false; // Error in the SQL statement
    }
}

// Check if data was sent via GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the ID from the URL query string
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        // Retrieve the ID from the query string
        $id = (int)$_GET['id'];
        $exists = checkIdExists($conn, $id);
        $response = ['exists' => $exists];
    } else {
        $response = ['exists' => false]; // Missing or invalid "id" parameter in the request
    }
} else {
    $response = ['exists' => false]; // Method not allowed for this endpoint
}

// Set the JSON content type header
header('Content-Type: application/json');

// Send the JSON response
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
?>