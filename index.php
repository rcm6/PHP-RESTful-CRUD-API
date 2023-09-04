<?php
// Get the requested URI from the server's environment variables
$request_uri = $_SERVER['REQUEST_URI'];

// Check if the requested URI matches a specific endpoint
if ($request_uri === '/PHP-RESTFUL_CRUD_API/create') {
    include_once 'endpoints/create.php';
} elseif ($request_uri === '/PHP-RESTFUL_CRUD_API/read') {
    include_once 'endpoints/read.php';
} elseif ($request_uri === '/PHP-RESTFUL_CRUD_API/update') {
    include_once 'endpoints/update.php';
} elseif ($request_uri === '/PHP-RESTFUL_CRUD_API/delete') {
    include_once 'endpoints/delete.php';
} else {
    // - Set a 404 HTTP response code
    http_response_code(404);
    // - Output a JSON response indicating that the endpoint was not found
    echo json_encode(array("message" => "Endpoint not found."));
}
?>
