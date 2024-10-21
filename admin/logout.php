<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Return a JSON response
$response = [
    "status" => "success",
    "message" => "Logged out successfully!"
];

header('Content-Type: application/json');
echo json_encode($response);
?>