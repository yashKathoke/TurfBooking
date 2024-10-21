<?php
// Database connection
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $booking_id = $data['booking_id'];
    $status = $data['status'];

    // Update booking status
    $sql = "UPDATE bookings SET status = :status WHERE id = :booking_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':booking_id', $booking_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Booking status updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update booking status.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>