<?php
// Start session
session_start();

// Check if the admin is logged in (ensure session is active)
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['turf_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access. Please log in."]);
    exit;
}

// Database connection
require_once 'db_connection.php';

// Function to upload new images
function uploadImages() {
    $uploadedFiles = [];
    $target_dir = "uploads/";
    $totalFiles = count($_FILES['images']['name']);
    
    // Loop through each uploaded file
    for ($i = 0; $i < $totalFiles; $i++) {
        $timestamp = time() . "_$i"; // Add index to avoid filename conflicts
        $imageFileType = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));
        $newFileName = "img_" . $timestamp . "." . $imageFileType;
        $target_file = $target_dir . $newFileName;
        
        // Check if the file is a valid image
        $check = getimagesize($_FILES["images"]["tmp_name"][$i]);
        if ($check === false) {
            continue; // Skip invalid images
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["images"]["tmp_name"][$i], $target_file)) {
            $uploadedFiles[] = $newFileName; // Store filename in array
        }
    }

    return $uploadedFiles;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get turf ID from the session
    $turf_id = $_SESSION['turf_id'];

    // Upload new images
    $new_image_paths = uploadImages();

    // Fetch the existing images from the database
    $sql = "SELECT images FROM turfs WHERE id = :turf_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':turf_id', $turf_id);
    $stmt->execute();
    $existing_images_json = $stmt->fetchColumn();

    // Decode the existing images JSON (if any)
    $existing_images = !empty($existing_images_json) ? json_decode($existing_images_json, true) : [];

    // Ensure existing_images is an array before merging
    if (!is_array($existing_images)) {
        $existing_images = [];
    }

    // Merge the existing and new images
    $all_images = array_merge($existing_images, $new_image_paths);

    // Convert the combined images array back to JSON
    $updated_images_json = json_encode($all_images);

    // Update the turf's images in the database
    $update_sql = "UPDATE turfs SET images = :images WHERE id = :turf_id";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bindParam(':images', $updated_images_json);
    $update_stmt->bindParam(':turf_id', $turf_id);

    if ($update_stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Images updated successfully!", "images" => $all_images]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update images."]);
    }
}
?>
