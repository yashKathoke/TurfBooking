<?php
// Database connection (ensure your credentials are correct)
require_once 'db_connection.php';
// Fetch turf data based on ID
if (isset($_GET['id'])) {
    $turf_id = $_GET['id'];

    // Fetch turf details
    $sql = "SELECT * FROM turfs WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $turf_id);
    $stmt->execute();
    $turfData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($turfData) {
        // Fetch available time slots from the turfs table
        $timeSlots = json_decode($turfData['time_slots'], true);

        // Fetch available sports
        $sports = json_decode($turfData['sports_available'], true);

        // Fetch images
        $images = json_decode($turfData['images'], true);

        // Fetch bookings for the turf
        $booking_sql = "SELECT * FROM bookings WHERE turf_id = :turf_id";
        $booking_stmt = $conn->prepare($booking_sql);
        $booking_stmt->bindParam(':turf_id', $turf_id);
        $booking_stmt->execute();
        $bookings = $booking_stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "status" => "success",
            "turfData" => $turfData,
            "timeSlots" => $timeSlots,
            "sports" => $sports,
            "images" => $images,
            "bookings" => $bookings
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Turf not found."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>