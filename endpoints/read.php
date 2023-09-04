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


// Retrieve data from the database
$sql = "SELECT * FROM items";
$result = mysqli_query($conn, $sql);

if (!$result) {
    $response = ['success' => false, 'message' => 'Failed to retrieve data: ' . mysqli_error($conn)];
} else {
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = ['success' => true, 'data' => $data];
}

// Set the JSON content type header
header('Content-Type: application/json');

// Send the JSON response
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
?>
