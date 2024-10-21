<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Sign Up for Turf Booking</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <style>
            body {
                background-color: #111827;
            }

            .max-w-md {
                max-width: 28rem;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="tel"] {
                background-color: #374151;
                border-color: #4b5563;
            }

            input[type="text"]:focus,
            input[type="email"]:focus,
            input[type="password"]:focus,
            input[type="tel"]:focus {
                border-color: #10b981;
                box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            }

            button[type="submit"] {
                background-color: #10b981;
                transition: all 0.2s ease-in-out;
            }

            button[type="submit"]:hover {
                background-color: #059669;
            }

            #togglePassword:focus {
                outline: none;
            }
        </style>
    </head>
    <body
        class="min-h-screen bg-gray-900 flex items-center justify-center px-4 sm:px-6 lg:px-8"
    >
        <div class="max-w-md w-full space-y-8 bg-gray-800 p-8 rounded-xl shadow-2xl">
            <div>
                <h1 class="text-3xl font-extrabold text-center text-white">
                    Sign Up for Turf Booking
                </h1>
                <p class="mt-2 text-center text-sm text-emerald-400">
                    Create an account to book your favorite turf
                </p>
            </div>
            <form class="mt-8 space-y-6" action="sign_up.php" method="POST">
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="name" class="sr-only">Name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            required
                            class="appearance-none  relative block w-full px-3 py-2 border border-gray-600 placeholder-gray-400 text-white bg-gray-700 rounded-md focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                            placeholder="Full Name"
                        />
                    </div>
                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            required
                            class="appearance-none  relative block w-full px-3 py-2 border border-gray-600 placeholder-gray-400 text-white bg-gray-700 rounded-md focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                            placeholder="Email Address"
                        />
                    </div>
                    <div>
                        <label for="phone" class="sr-only">Phone Number</label>
                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            required
                            class="appearance-none  relative block w-full px-3 py-2 border border-gray-600 placeholder-gray-400 text-white bg-gray-700 rounded-md focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                            placeholder="Phone Number"
                        />
                    </div>
                    <div>
                        <label for="city" class="sr-only">City</label>
                        <input
                            id="city"
                            name="city"
                            type="text"
                            required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-600 placeholder-gray-400 text-white bg-gray-700 rounded-md focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm"
                            placeholder="City"
                        />
                    </div>
                    <div class="relative">
                        <label for="password" class="sr-only">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="appearance-none  relative block w-full px-3 py-2 border border-gray-600 placeholder-gray-400 text-white bg-gray-700 rounded-md focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm pr-10"
                            placeholder="Password"
                        />
                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                        >
                            <i
                                id="passwordIcon"
                                data-lucide="eye"
                                class="h-5 w-5 text-gray-400"
                            ></i>
                        </button>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                    >
                        Sign Up
                    </button>
                </div>
                <div class="text-sm text-center text-gray-400">
                    Already have an account? <a href="log_in.php" class="text-emerald-400 hover:text-emerald-500">Log in</a>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const passwordInput = document.getElementById("password");
                const togglePassword = document.getElementById("togglePassword");
                const passwordIcon = document.getElementById("passwordIcon");

                togglePassword.addEventListener("click", function () {
                    const type =
                        passwordInput.getAttribute("type") === "password"
                            ? "text"
                            : "password";
                    passwordInput.setAttribute("type", type);

                    if (type === "password") {
                        passwordIcon.setAttribute("data-lucide", "eye");
                    } else {
                        passwordIcon.setAttribute("data-lucide", "eye-off");
                    }

                    lucide.createIcons();
                });

                lucide.createIcons();
            });
        </script>
    </body>
</html>
