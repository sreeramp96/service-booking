<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Service Booking App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 text-center">
        <h1 class="text-4xl font-bold mb-4">Welcome to Service Booking App</h1>
        <p class="text-lg text-gray-600 max-w-xl mb-6">
            Book services with ease. Whether you're a customer looking for top-rated services or a vendor managing your
            schedule, we've got you covered.
        </p>

        <div class="flex gap-4">
            <a href="{{ route('login') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow">
                Login
            </a>
            <a href="{{ route('register') }}"
                class="bg-white border border-blue-600 text-blue-600 font-semibold px-6 py-2 rounded shadow hover:bg-blue-50">
                Register
            </a>
        </div>
    </div>
</body>

</html>