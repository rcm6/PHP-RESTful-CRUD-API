<?php
// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Include database config
include_once './includes/config.php';

// Get the requested URI from the server's environment variables
$request_uri = $_SERVER['REQUEST_URI'];
// Get the HTTP request method (e.g., GET, POST, PUT, DELETE)
$request_method = $_SERVER['REQUEST_METHOD'];

// Routing logic for all endpoints
// Check if the requested URI matches a specific endpoint
if ($request_uri === '/PHP-Restful-CRUD-API/create') {
    include_once 'endpoints/create.php';
} elseif ($request_uri === '/PHP-Restful-CRUD-API/read') {
    include_once 'endpoints/read.php';
} elseif (strpos($request_uri, '/PHP-Restful-CRUD-API/update') === 0) {
    if ($request_method === 'POST') {
        // Handle POST requests for update endpoint
        include_once 'endpoints/update.php';
    } else {
        http_response_code(405); // Method Not Allowed
        echo 'Method not allowed for this endpoint.';
    }
} elseif (strpos($request_uri, '/PHP-Restful-CRUD-API/delete') === 0) {
    if ($request_method === 'POST') {
        // Handle POST requests for delete endpoint
        include_once 'endpoints/delete.php';
    } else {
        http_response_code(405); // Method Not Allowed
        echo 'Method not allowed for this endpoint.';
    }
} elseif (strpos($request_uri, '/PHP-Restful-CRUD-API/check-id-exists') === 0) {
    if ($request_method === 'GET') {
        // Handle GET requests for check-id-exists endpoint
        include_once 'endpoints/check-id-exists.php';
    } else {
        http_response_code(405); // Method Not Allowed
        echo 'Method not allowed for this endpoint.';
    }
/*
elseif (strpos($request_uri, '/PHP-Restful-CRUD-API/check-id-exists') === 0) {
    
    // Extract the ID from the query string
    $query_string = parse_url($request_uri, PHP_URL_QUERY);
    parse_str($query_string, $query_params);

    if (isset($query_params['id'])) {
        $id = $query_params['id'];
        include_once 'endpoints/check-id-exists.php';
    } else {
        // Handle the case where 'id' is not provided in the query string
        http_response_code(400); // Bad Request
        echo json_encode(array("message" => "Missing 'id' parameter."));
    }
*/
} else {
    http_response_code(404);
    echo 'Endpoint not found.';
}
?>

