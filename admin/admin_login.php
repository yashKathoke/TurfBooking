<?php
// Start the session
session_start();


// db_connection.php
require_once 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST['identifier']; // Email or phone
    $password = $_POST['password'];
    
    // Query to check if the identifier matches email or phone
    $sql = "SELECT * FROM admin WHERE email = :identifier OR phone = :identifier LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':identifier', $identifier);
    $stmt->execute();
    
    // Fetch the result
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if admin exists and verify password
    if ($admin && password_verify($password, $admin['password'])) {
        // If password matches, set session variables and redirect to the dashboard
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['turf_id'] = $admin['turf_id']; // Store the turf_id for later use
        
        // Redirect to the dashboard (adjust the path as needed)
        header("Location: /turfbooking/admin/manage.html");
        exit();
    } else {
        // Invalid credentials, redirect back with an error message
        $_SESSION['error'] = "Invalid email/phone or password.";
        header("Location: login.php"); // Redirect back to the login page
        exit();
    }
} else {
    // Redirect to login page if accessed directly
    header("Location: login.php");
    exit();
}
?>

