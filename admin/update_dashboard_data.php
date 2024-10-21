<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = $_SESSION['admin_id'];

    // Update Admin Data
    if (isset($_POST['adminData'])) {
        $adminData = json_decode($_POST['adminData'], true);
        
        $sql = "UPDATE admin SET name = :name, email = :email, phone = :phone WHERE id = :admin_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $adminData['name']);
        $stmt->bindParam(':email', $adminData['email']);
        $stmt->bindParam(':phone', $adminData['phone']);
        $stmt->bindParam(':admin_id', $admin_id);
        $stmt->execute();
    }

    // Update Turf Data
    if (isset($_POST['turfData'])) {
        $turfData = json_decode($_POST['turfData'], true);
        $turf_id = $_POST['turf_id']; // Retrieve the associated turf ID

        $sql = "UPDATE turfs SET name = :name, address = :address, phone = :phone, email = :email, 
                rating = :rating, city = :city, area = :area WHERE id = :turf_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $turfData['name']);
        $stmt->bindParam(':address', $turfData['address']);
        $stmt->bindParam(':phone', $turfData['phone']);
        $stmt->bindParam(':email', $turfData['email']);
        $stmt->bindParam(':rating', $turfData['rating']);
        $stmt->bindParam(':city', $turfData['city']);
        $stmt->bindParam(':area', $turfData['area']);
        $stmt->bindParam(':turf_id', $turf_id);
        $stmt->execute();
    }

    echo json_encode(['status' => 'success', 'message' => 'Data updated successfully']);
}
?>
