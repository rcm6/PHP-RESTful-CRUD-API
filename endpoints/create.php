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

// Check if data was sent via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the POST request
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if 'name' and 'description' are present in the JSON data
    if (isset($data['name']) && isset($data['description'])) {
        // Retrieve the values from the JSON data
        $name = $data['name'];
        $description = $data['description'];

        // Perform input validation

        if (empty($name) || empty($description)) {
            $response = ['success' => false, 'message' => 'Name and description are required.'];
        } else {
            // Insert data into the database
            $sql = "INSERT INTO items (name, description) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ss", $name, $description);
                if (mysqli_stmt_execute($stmt)) {
                    $response = ['success' => true, 'message' => 'Item created successfully.'];
                } else {
                    $response = ['success' => false, 'message' => 'Item creation failed: ' . mysqli_error($conn)];
                }
                mysqli_stmt_close($stmt);
            } else {
                $response = ['success' => false, 'message' => 'Error in preparing the SQL statement.'];
            }
        }
    } else {
        $response = ['success' => false, 'message' => 'Invalid JSON data.'];
    }
    
    // Set the JSON content type header
    header('Content-Type: application/json');
    
    // Send the JSON response
    echo json_encode($response);
} else {
    // Invalid request method
    header("HTTP/1.0 400 Bad Request");
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

// Close the database connection
mysqli_close($conn);
?>
