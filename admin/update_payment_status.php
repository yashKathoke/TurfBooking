<?php
session_start();

require_once 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$booking_id = $data['booking_id'];
$payment_status = $data['payment_status'];

// Prepare an SQL statement to update payment_status
$query = "UPDATE bookings SET payment_status = :payment_status WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindValue(':payment_status', $payment_status, PDO::PARAM_STR);
$stmt->bindValue(':id', $booking_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Payment status updated']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update payment status']);
}

$stmt = null;
$conn = null;
?>
