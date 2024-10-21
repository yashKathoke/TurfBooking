<?php
session_start();

// Include the database connection
require_once 'db_connection.php'; // or use 'include' if you prefer

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch bookings from the database
$sql = "SELECT * FROM bookings WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt->closeCursor();
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Turf Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"}
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center text-primary-600">My Turf Bookings</h1>
        <div id="bookings-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Bookings will be dynamically inserted here -->
        </div>
    </div>

    <template id="booking-template">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold booking-name"></h2>
                    <span class="px-2 py-1 text-sm font-semibold rounded-full booking-status"></span>
                </div>
                <div class="space-y-2 text-sm">
                    <p class="flex items-center">
                        <i class="fas fa-calendar-alt mr-2 text-primary-500"></i>
                        <span class="booking-date"></span>
                    </p>
                    <p class="flex items-center">
                        <i class="fas fa-clock mr-2 text-primary-500"></i>
                        <span class="booking-time"></span>
                    </p>
                    <p class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-primary-500"></i>
                        <span class="booking-turf"></span>
                    </p>
                    <p class="flex items-center">
                        <i class="fas fa-phone mr-2 text-primary-500"></i>
                        <span class="booking-phone"></span>
                    </p>
                    <p class="flex items-center">
                        <i class="fas fa-envelope mr-2 text-primary-500"></i>
                        <span class="booking-email"></span>
                    </p>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 flex justify-between items-center">
                <span class="text-sm font-semibold booking-payment"></span>
            </div>
        </div>
    </template>

    <script>
        const bookings = <?php echo json_encode($bookings); ?>;

        function getStatusColor(status) {
            switch (status) {
                case 'confirmed': return 'bg-green-500 text-white';
                case 'pending': return 'bg-yellow-500 text-white';
                case 'cancelled': return 'bg-red-500 text-white';
                default: return 'bg-gray-500 text-white';
            }
        }

        function formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        function renderBookings() {
            const container = document.getElementById('bookings-container');
            const template = document.getElementById('booking-template');

            bookings.forEach(booking => {
                const bookingElement = template.content.cloneNode(true);

                bookingElement.querySelector('.booking-name').textContent = booking.name;
                bookingElement.querySelector('.booking-status').textContent = booking.status;
                bookingElement.querySelector('.booking-status').classList.add(...getStatusColor(booking.status).split(' '));
                bookingElement.querySelector('.booking-date').textContent = formatDate(booking.date);
                bookingElement.querySelector('.booking-time').textContent = booking.time_slot;
                bookingElement.querySelector('.booking-turf').textContent = `Turf ID: ${booking.turf_id}`;
                bookingElement.querySelector('.booking-phone').textContent = booking.phone;
                bookingElement.querySelector('.booking-email').textContent = booking.email;
                bookingElement.querySelector('.booking-payment').textContent = `Payment: ${booking.payment_status}`;
                bookingElement.querySelector('.booking-payment').classList.add(
                    booking.payment_status === 'done' ? 'text-green-600' : 'text-red-600'
                );

                container.appendChild(bookingElement);
            });
        }

        renderBookings();
    </script>
</body>
</html>
