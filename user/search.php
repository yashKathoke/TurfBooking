<?php
// Database connection
require_once 'db_connection.php';

// Check if the city is passed from the form
if (isset($_GET['city'])) {
    $city = $_GET['city'];

    // Fetch turfs from the database based on the city
    $sql = "SELECT * FROM turfs WHERE city = :city";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':city', $city);
    $stmt->execute();
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($results) {
        // Pass results to the bookturf.php page via GET request
        header("Location: bookturf.php?results=" . urlencode(json_encode($results)));
        exit;
    } else {
        // No results found
        echo json_encode(["status" => "error", "message" => "No turfs found in the selected city."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "City not provided."]);
}
?>
