<?php
// Get the requested URI from the server's environment variables
$request_uri = $_SERVER['REQUEST_URI'];

// Check if the requested URI matches a specific endpoint
if ($request_uri === '/PHP-RESTFUL_CRUD_API/create') {
    // If the URI matches '/PHP-RESTFUL_CRUD_API/create', include the 'create.php' file
    include_once 'endpoints/create.php';
} elseif ($request_uri === '/PHP-RESTFUL_CRUD_API/read') {
    // If the URI matches '/PHP-RESTFUL_CRUD_API/read', include the 'read.php' file
    include_once 'endpoints/read.php';
} elseif ($request_uri === '/PHP-RESTFUL_CRUD_API/update') {
    // If the URI matches '/PHP-RESTFUL_CRUD_API/update', include the 'update.php' file
    include_once 'endpoints/update.php';
} elseif ($request_uri === '/PHP-RESTFUL_CRUD_API/delete') {
    // If the URI matches '/PHP-RESTFUL_CRUD_API/delete', include the 'delete.php' file
    include_once 'endpoints/delete.php';
} else {
    // If none of the above conditions are met
    // - Set a 404 HTTP response code
    http_response_code(404);
    // - Output a JSON response indicating that the endpoint was not found
    echo json_encode(array("message" => "Endpoint not found."));
}
?>
