<?php
session_start(); // Start the session

// Database connection (ensure your credentials are correct)
require_once 'db_connection.php';

// Handle booking submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $turf_id = $_POST['turf_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $time_slot = $_POST['time_slot'];
    $date = $_POST['date'];
    $payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : 'remaining'; // Default value
    $user_id = $_SESSION['user_id']; // Retrieve user_id from session

    // Check if the time slot is available
    $check_sql = "SELECT * FROM bookings WHERE turf_id = :turf_id AND time_slot = :time_slot AND date = :date AND status = 'confirmed'";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':turf_id', $turf_id);
    $check_stmt->bindParam(':time_slot', $time_slot);
    $check_stmt->bindParam(':date', $date);
    $check_stmt->execute();
    $existingBooking = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingBooking) {
        // Insert booking data
        $sql = "INSERT INTO bookings (turf_id, name, phone, email, time_slot, date, status, payment_status, user_id) VALUES (:turf_id, :name, :phone, :email, :time_slot, :date, 'confirmed', :payment_status, :user_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':turf_id', $turf_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':time_slot', $time_slot);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':payment_status', $payment_status); // Bind new field
        $stmt->bindParam(':user_id', $user_id); // Bind user_id from session
        $stmt->execute();

        echo json_encode(["status" => "success", "message" => "Booking confirmed."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Time slot already booked."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>