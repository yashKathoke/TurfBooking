<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: log_in.php");
    exit();
}

// Fetch the user's name from the session
$user_name = $_SESSION['user_name'];

// Extract initials from the user's name
$initials = '';
if (!empty($user_name)) {
    $name_parts = explode(' ', $user_name);
    foreach ($name_parts as $part) {
        $initials .= strtoupper($part[0]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurfWorld</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    
</head>

<body class="bg-gray-100">
    <div class="main">
        <div class="page1">


            <nav class="bg-white shadow-lg fixed top-0 left-0 w-full z-50 h-20">
                <div class="max-w-6xl mx-auto px-4">
                    <div class="flex justify-between items-center h-20">
                        <div class="flex items-center">
                            <a href="#" class="flex items-center">
                                <svg class="h-10 w-10 mr-2 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-semibold text-gray-500 text-xl">Company Logo</span>
                            </a>
                        </div>
                       
                        <div class="flex items-center">
                            <button id="menu-toggle" class="outline-none menu-button" aria-label="Toggle menu">
                                <div class="hamburger-icon">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>

            <div id="menu-content"
                class="fixed top-0 right-0 w-1/4 h-full bg-gray-800 shadow-lg z-50 menu-content closed">
                <div class="flex justify-between items-center p-4">
        <!-- User Initials (Letter Logo) aligned to the left -->
        <div class="flex items-center">
            <div class="h-10 w-10 flex items-center justify-center bg-blue-500 text-white rounded-full">
                <?php echo $initials; ?>
            </div>

            <!-- Logout Button next to initials -->
            <form action="logout.php" method="POST" class="ml-4">
                <button type="submit" class="text-gray-300 hover:text-white bg-red-500 hover:bg-red-600 font-bold py-2 px-4 rounded">
                    Logout
                </button>
            </form>
        </div>

        <!-- Close Button aligned to the right -->
        <button id="close-menu" class="text-gray-300 hover:text-white">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
               
       
                    <div class="flex-grow overflow-y-auto">
                        <a href="index.php"
                            class="block px-4 py-2 text-xl mb-3 ml-2 font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition duration-300">Home</a>

                            <a href="bookings.php" class="block px-4 py-2 text-xl mb-3 ml-2 font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition duration-300">Bookings</a>
                        <a href="#"
                            class="block px-4 py-2 text-xl mb-3 ml-2 font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition duration-300">Contact</a>
                        <a href="#"
                            class="block px-4 py-2 text-xl mb-3 ml-2 font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition duration-300">Blog</a>
                            <?php if ($user_name): ?>
                <a href="profile.php" class="block px-4 py-2 text-xl mb-3 ml-2 font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition duration-300">Profile</a>
            <?php endif; ?>
                    </div>
                </div>
            </div>

            <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>
            <div class="image-container relative">
                <img src="beach.jpg" alt="Beach" class="w-full h-[550px] object-cover">
                <div class="image-text absolute inset-0 flex items-center justify-center text-white">
                    <h1 class="text-2xl">Welcome to TurfWorld</h1>
                </div>

                <!-- Overlapping Card -->
<div class="overlapping-card absolute bottom-[-25%] left-1/2 transform -translate-x-1/2 w-3/4  p-8 rounded-lg shadow-lg">
    <!-- Search Bar -->
    <form id="search-form" action="search.php" method="GET" class="mb-6"> <!-- Update action to search.php -->
        <div class="flex items-center space-x-3 p-4 bg-gray-200 rounded-lg shadow-md">
            <svg class="w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 11c0 2.21 1.79 4 4 4s4-1.79 4-4-1.79-4-4-4-4 1.79-4 4zm0 10.75c1.81-1.44 6-6.04 6-9.75 0-3.31-2.69-6-6-6s-6 2.69-6 6c0 3.71 4.19 8.31 6 9.75z" />
            </svg>
            <input id="search-input" type="text" name="city" placeholder="Search location..." class="w-full p-2 bg-blue-50 border-2 border-blue-500 rounded-md text-gray-700 placeholder-gray-400 focus:outline-none focus:border-blue-700" required>
        </div>
    </form>

    <!-- Submit Button -->
    <div class="text-center mt-8">
        <button id="search-btn" form="search-form" class="bg-green-500 text-white font-bold py-2 px-6 rounded-full hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
            Search Now
        </button>
    </div>
</div>

    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const closeMenu = document.getElementById('close-menu');
        const menuContent = document.getElementById('menu-content');
        const overlay = document.getElementById('overlay');

        function toggleMenu() {
            menuContent.classList.toggle('open');
            menuContent.classList.toggle('closed');
            overlay.classList.toggle('hidden');
            menuToggle.classList.toggle('text-blue-500');
        }

        menuToggle.addEventListener('click', toggleMenu);
        closeMenu.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);
    </script>

</body>

</html>