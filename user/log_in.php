<?php
session_start();

// Database connection
require_once 'db_connection.php';

$message = ""; // To store error messages

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password']; // Password from the form

    // Fetch the user from the database by email using prepared statements
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Correct credentials, log the user in
            $_SESSION['user_id'] = $user['id'];  // Store user ID in session
            $_SESSION['user_name'] = $user['name'];  // Store user name in session
            
            // Redirect to index.php after successful login
        //     header("Location: /");
            exit(); // Make sure to stop further script execution
        } else {
            // Password is incorrect
            $message = "Incorrect email or password.";
        }
    } else {
        // Email not found
        $message = "Incorrect email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-900 flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-gray-800 p-8 rounded-xl shadow-2xl">
                <div>
                        <h1 class="text-3xl font-extrabold text-center text-white">Login to Your Account</h1>
                        <p class="mt-2 text-center text-sm text-emerald-400">
                                Access your account here.
                        </p>
                </div>

                <!-- Show message if set -->
                <?php if ($message): ?>
                        <div class="mt-4 text-center text-white bg-red-500 p-2 rounded">
                                <?php echo $message; ?>
                        </div>
                <?php endif; ?>

                <!-- Login form -->
                <form class="mt-8 space-y-6" action="log_in.php" method="POST">
                        <div class="rounded-md shadow-sm -space-y-px">
                                <div>
                                        <label for="email" class="sr-only">Email</label>
                                        <input id="email" name="email" type="email" required
                                                     class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-600 placeholder-gray-400 text-white bg-gray-700 rounded-t-md focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 sm:text-sm"
                                                     placeholder="Email" />
                                </div>
                                <div class="relative">
                                        <label for="password" class="sr-only">Password</label>
                                        <input id="password" name="password" type="password" required
                                                     class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-600 placeholder-gray-400 text-white bg-gray-700 rounded-b-md focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 focus:z-10 sm:text-sm pr-10"
                                                     placeholder="Password" />
                                </div>
                        </div>

                        <div>
                                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                                        Login
                                </button>
                        </div>
                </form>

                <!-- Signup redirect section -->
                <div class="mt-4 text-center text-sm text-emerald-400">
                        Don't have an account? <a href="signup.php" class="text-emerald-500 hover:text-emerald-700">Sign up here</a>
                </div>
        </div>
</body>
</html>
