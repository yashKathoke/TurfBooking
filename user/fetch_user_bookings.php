<?php
session_start();

require_once 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Fetch user's bookings
    $bookings_sql = "SELECT b.*, t.name as turf_name 
                     FROM bookings b 
                     JOIN turfs t ON b.turf_id = t.id 
                     WHERE b.user_id = :user_id 
                     ORDER BY b.date DESC, b.time_slot ASC";
    $stmt = $conn->prepare($bookings_sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return data in JSON format
    echo json_encode([
        'status' => 'success',
        'bookings' => $bookings
    ]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>