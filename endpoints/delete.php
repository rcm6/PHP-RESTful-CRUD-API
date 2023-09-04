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

// Function to delete an item by ID
function deleteItem($conn, $id) {

    // Delete data from the database
    $sql = "DELETE FROM items WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            return ['success' => true, 'message' => 'Item deleted successfully.'];
        } else {
            return ['success' => false, 'message' => 'Item deletion failed: ' . mysqli_error($conn)];
        }
        mysqli_stmt_close($stmt);
    } else {
        return ['success' => false, 'message' => 'Error in preparing the SQL statement.'];
    }
}

// Check if data was sent via GET or POST request
if ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID from the URL query string or POST data
    if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
        // Retrieve the ID from the query string or POST data
        $id = (int)$_REQUEST['id'];
        $response = deleteItem($conn, $id);
    } else {
        $response = ['success' => false, 'message' => 'Missing or invalid "id" parameter in the request.'];
    }
} else {
    $response = ['success' => false, 'message' => 'Method not allowed for this endpoint.'];
}

// Set the JSON content type header
header('Content-Type: application/json');

// Send the JSON response
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
?>
