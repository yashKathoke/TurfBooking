<?php
// Start session and connect to the database
session_start();
require_once 'db_connection.php';

// Get the turf ID from the request
$turf_id = $_GET['id'];

// Fetch turf data including images
$sql = "SELECT name, images FROM turfs WHERE id = :turf_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':turf_id', $turf_id);
$stmt->execute();
$turf = $stmt->fetch(PDO::FETCH_ASSOC);

if ($turf) {
    // Convert images from JSON format
    $turf['images'] = json_decode($turf['images'], true);
    echo json_encode(["status" => "success", "turf" => $turf]);
} else {
    echo json_encode(["status" => "error", "message" => "Turf not found."]);
}
?>
