<?php
session_start();

require_once 'db_connection.php';
// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$admin_id = $_SESSION['admin_id'];

try {
    // Fetch admin data
    $admin_sql = "SELECT phone, email, turf_id FROM admin WHERE id = :admin_id LIMIT 1";
    $stmt = $conn->prepare($admin_sql);
    $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
    $stmt->execute();
    $adminData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$adminData) {
        echo json_encode(['status' => 'error', 'message' => 'Admin not found']);
        exit();
    }

    // Fetch turf data related to this admin
    $turf_sql = "SELECT * FROM turfs WHERE id = :turf_id";
    $stmt = $conn->prepare($turf_sql);
    $stmt->bindParam(':turf_id', $adminData['turf_id'], PDO::PARAM_INT);
    $stmt->execute();
    $turfData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$turfData) {
        echo json_encode(['status' => 'error', 'message' => 'Turf not found']);
        exit();
    }

    // Fetch bookings related to this turf
    $bookings_sql = "SELECT * FROM bookings WHERE turf_id = :turf_id";
    $stmt = $conn->prepare($bookings_sql);
    $stmt->bindParam(':turf_id', $adminData['turf_id'], PDO::PARAM_INT);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return data in JSON format
    echo json_encode([
        'status' => 'success',
        'adminData' => $adminData,
        'turfData' => $turfData,
        'bookings' => $bookings
    ]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>