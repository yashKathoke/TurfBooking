<?php
// Database connection (ensure your credentials are correct)
require_once 'db_connection.php';

// Function to upload multiple images
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
            $uploadedFiles[] = $newFileName;
        }
    }
    return $uploadedFiles;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $area = $_POST['area'];
    $rating = $_POST['rating'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $timeSlots = json_encode($_POST['time_slots']); // JSON-encoded array of time slots
    $sports = json_encode($_POST['sports']); // JSON-encoded array of sports

    // Check if affiliated_people key exists and is properly structured
    $affiliatedPeople = [];
    if (isset($_POST['affiliated_people']) && is_array($_POST['affiliated_people'])) {
        foreach ($_POST['affiliated_people'] as $person) {
            if (isset($person['name']) && isset($person['mobile'])) {
                $affiliatedPeople[] = [
                    'name' => $person['name'],
                    'mobile' => $person['mobile']
                ];
            }
        }
    }
    $affiliatedPeople = json_encode($affiliatedPeople); // JSON-encoded array of key-value pairs

    // Upload images
    $uploadedImages = uploadImages();
    $images = json_encode($uploadedImages);

    // Insert turf data
    $sql = "INSERT INTO turfs (name, address, phone, email, rating, images, city, area, time_slots, sports_available, affiliated_people) 
            VALUES (:name, :address, :phone, :email, :rating, :images, :city, :area, :time_slots, :sports_available, :affiliated_people)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':images', $images);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':area', $area);
    $stmt->bindParam(':time_slots', $timeSlots);
    $stmt->bindParam(':sports_available', $sports);
    $stmt->bindParam(':affiliated_people', $affiliatedPeople);

    if ($stmt->execute()) {
        $turf_id = $conn->lastInsertId();

        // Insert admin data
        $admin_sql = "INSERT INTO admin (turf_id, email, password, phone) VALUES (:turf_id, :email, :password, :phone)";
        $admin_stmt = $conn->prepare($admin_sql);
        $admin_stmt->bindParam(':turf_id', $turf_id);
        $admin_stmt->bindParam(':email', $email);
        $admin_stmt->bindParam(':password', $password);
        $admin_stmt->bindParam(':phone', $phone);

        if ($admin_stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Turf and admin registered successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to register admin. Please try again."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to register turf. Please try again."]);
    }
}
?>