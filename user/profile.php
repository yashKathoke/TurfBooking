<?php
session_start();

// Check if user is logged in, otherwise redirect to login
if (!isset($_SESSION['user_id'])) {
    header("Location: log_in.php");
    exit();
}

// Database connection
require_once 'db_connection.php';

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update user info in the database
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $city = $conn->real_escape_string($_POST['city']);
    $new_password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

    // Update query
    $sql = "UPDATE users SET name = '$name', email = '$email', phone = '$phone', city = '$city'";
    
    // Only update password if provided
    if ($conn->query($sql) === TRUE) {
        // Set the message and update session name
        $message = "Profile updated successfully!";
        $_SESSION['user_name'] = $name;  // Update session name

        // Use JavaScript to redirect after 2 seconds
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'page2.php';
                }, 2000);
              </script>";
    } else {
        $message = "Error updating profile: " . $conn->error;
    }
}


// Get the current user data
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto py-16">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Update Profile</h1>

        <?php if ($message): ?>
            <div class="p-4 mb-6 text-white bg-green-500 rounded-md">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="profile.php" method="POST" class="bg-white p-8 rounded-lg shadow-lg">
            <!-- Name Field -->
            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required
                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Email Field -->
            <div class="mb-6">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required
                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Phone Field -->
            <div class="mb-6">
                <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required
                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- City Field -->
            <div class="mb-6">
                <label for="city" class="block text-gray-700 font-semibold mb-2">City</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" required
                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Password Field (Optional) -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-semibold mb-2">New Password (Leave blank to keep current password)</label>
                <input type="password" id="password" name="password"
                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full py-3 px-4 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-600 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</body>

</html>
