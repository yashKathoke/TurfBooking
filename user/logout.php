<?php
session_start();

// Destroy the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to page2.php after logout
header("Location: /turfbooking");
exit();
?>
