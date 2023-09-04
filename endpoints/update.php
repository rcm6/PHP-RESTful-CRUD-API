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

// Function to update an item by ID
function updateItem($conn, $id, $name, $description) {

    // Update data in the database
    $sql = "UPDATE items SET name = ?, description = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssi", $name, $description, $id);
        if (mysqli_stmt_execute($stmt)) {
            return ['success' => true, 'message' => 'Item updated successfully.'];
        } else {
            return ['success' => false, 'message' => 'Item update failed: ' . mysqli_error($conn)];
        }
        mysqli_stmt_close($stmt);
    } else {
        return ['success' => false, 'message' => 'Error in preparing the SQL statement.'];
    }
}

// Check if data was sent via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the POST request
    $data = json_decode(file_get_contents('php://input'), true);

    // Check for JSON parsing errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        $response = ['success' => false, 'message' => 'Invalid JSON data: ' . json_last_error_msg()];
    } else {
        // Check if 'id', 'name', and 'description' are present in the JSON data
        if (isset($data['id']) && isset($data['name']) && isset($data['description'])) {
            // Retrieve the values from the JSON data
            $id = $data['id'];
            $name = $data['name'];
            $description = $data['description'];

            $response = updateItem($conn, $id, $name, $description);
        } else {
            $response = ['success' => false, 'message' => 'Invalid JSON data.'];
        }
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
