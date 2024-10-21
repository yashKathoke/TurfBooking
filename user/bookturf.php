<?php
// Database connection
require_once 'db_connection.php';
// Fetch turfs with pagination
function fetchTurfs($conn, $offset = 0, $limit = 6) {
    $sql = "SELECT * FROM turfs LIMIT :offset, :limit";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get the current offset from the request
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

// Fetch turfs
$results = fetchTurfs($conn, $offset);


$turf_id = isset($_GET['turf_id']) ? (int)$_GET['turf_id'] : null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Turfs</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=1.1">
</head>
<body class="bg-gray-100">

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
            <div class="pt-20 flex justify-center">
    <!-- Relative parent container -->
    <div class="relative w-full">
    <img src="beach.jpg" alt="Turf Image" class="w-full  object-cover" style="height: 410px;">
        <!-- Centered text over the image -->
        <div class="absolute inset-0 flex items-center justify-center">
            <h1 class="text-white text-2xl ">Centered Text</h1>
        </div>
    </div>
</div>

            <div id="menu-content"
                class="fixed top-0 right-0 w-1/4 h-full bg-gray-800 shadow-lg z-50 menu-content closed">
                <div class="flex flex-col h-full">
                    <div class="flex justify-end p-4">
                        <button id="close-menu" class="text-gray-300 hover:text-white">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-grow overflow-y-auto">
                        <a href="#"
                            class="block px-4 py-2 text-xl mb-3 ml-2 font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition duration-300">Home</a>
                        <a href="#"
                            class="block px-4 py-2 text-xl mb-3 ml-2 font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition duration-300">About</a>
                        <a href="#"
                            class="block px-4 py-2 text-xl mb-3 ml-2 font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition duration-300">Services</a>
                        <a href="#"
                            class="block px-4 py-2 text-xl mb-3 ml-2 font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition duration-300">Products</a>
                        <a href="#"
                            class="block px-4 py-2 text-xl mb-3 ml-2 font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition duration-300">Contact</a>
                        <a href="#"
                            class="block px-4 py-2 text-xl mb-3 ml-2 font-medium text-gray-300 hover:text-white hover:bg-gray-700 transition duration-300">Blog</a>
                    </div>
                </div>
            </div>


 
<?php

$results = []; 


$sql = "SELECT * FROM turfs"; 
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="container mx-auto p-8 mt-15">
    <h1 class="text-3xl font-bold text-center mb-8">Available Turfs in Your Selected City</h1>
    
    <?php if (count($results) > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($results as $turf): ?>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <?php if (!empty($turf['images'])): ?>
                        <?php 
                            $images = json_decode($turf['images'], true); 
                            if (is_array($images) && !empty($images)):
                        ?>
                            <!-- Display the first image -->
                            <img src="/turfbooking/admin/uploads/<?= htmlspecialchars($images[0]); ?>" alt="Turf Image" class="w-full h-64 object-cover rounded-t-lg mb-4">
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <h2 class="text-xl font-bold mb-2"><?= htmlspecialchars($turf['name']); ?></h2>
                    <p class="text-gray-700 mb-2"><?= htmlspecialchars($turf['address']); ?></p>

                    <p class="text-gray-700 mb-2"><strong>Rating:</strong> <?= htmlspecialchars($turf['rating']); ?></p>
                    
                    <?php if (is_array($images) && count($images) > 1): ?>
                        <div class="flex space-x-2 mt-4">
                            <?php foreach ($images as $image): ?>
                                <img src="/turfbooking/admin/uploads/<?= htmlspecialchars($image); ?>" alt="Turf Image" class="w-20 h-20 object-cover rounded-lg">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Button to redirect to turf page -->
                    <a href="turf.html?id=<?= htmlspecialchars($turf['id']); ?>" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-red-500">No turfs available in the selected city.</p>
    <?php endif; ?>
</div>

<script>
    let offset = <?= $offset + count($results); ?>; // Update offset for next load

    document.getElementById('load-more-button').addEventListener('click', function() {
        fetch(`book_turf.php?offset=${offset}`)
            .then(response => response.text())
            .then(data => {
                // Append the new turf cards to the existing ones
                document.getElementById('turf-cards').insertAdjacentHTML('beforeend', data);

                offset += 6; // Increase offset for the next fetch

                // Hide the button if fewer than 6 new turfs were loaded
                if (data.trim() === '') {
                    document.getElementById('load-more').style.display = 'none';
                }
            });
    });
</script>

    <!-- Script for handling the menu toggle -->
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const menuContent = document.getElementById('menu-content');
        const closeMenu = document.getElementById('close-menu');

        menuToggle.addEventListener('click', () => {
            menuContent.classList.toggle('closed');
            menuContent.classList.toggle('open');
            menuToggle.classList.toggle('open');
        });

        closeMenu.addEventListener('click', () => {
            menuContent.classList.add('closed');
            menuContent.classList.remove('open');
            menuToggle.classList.remove('open');
        });

        const turfId = <?php echo json_encode($results); ?>;
        // Print the turf ID in the console
        console.log("Turf ID:", turfId);
    </script>
</body>
</html>
