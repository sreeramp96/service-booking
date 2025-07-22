<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiceBook - Your Service Marketplace</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-slow': 'bounce 3s infinite',
                        'fade-in-up': 'fade-in-up 0.8s ease-out',
                        'slide-in-left': 'slide-in-left 0.8s ease-out',
                        'slide-in-right': 'slide-in-right 0.8s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        'fade-in-up': {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        'slide-in-left': {
                            '0%': { opacity: '0', transform: 'translateX(-30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                        'slide-in-right': {
                            '0%': { opacity: '0', transform: 'translateX(30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .blob {
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: blob 7s infinite;
        }

        @keyframes blob {
            0% {
                border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            }

            25% {
                border-radius: 58% 42% 75% 25% / 76% 46% 54% 24%;
            }

            50% {
                border-radius: 50% 50% 33% 67% / 55% 27% 73% 45%;
            }

            75% {
                border-radius: 33% 67% 58% 42% / 63% 68% 32% 37%;
            }

            100% {
                border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            }
        }
    </style>
</head>

<body class="font-inter overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-xl">S</span>
                    </div>
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        ServiceBook
                    </span>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-blue-600 transition-colors">Features</a>
                    <a href="#services" class="text-gray-600 hover:text-blue-600 transition-colors">Services</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-blue-600 transition-colors">How it Works</a>
                    <a href="#testimonials" class="text-gray-600 hover:text-blue-600 transition-colors">Reviews</a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                        class="text-gray-600 hover:text-blue-600 transition-colors font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-full hover:shadow-lg transform hover:scale-105 transition-all duration-300 font-medium">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 gradient-bg"></div>
        <div
            class="absolute top-20 left-20 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-slow">
        </div>
        <div
            class="absolute top-40 right-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-slow animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse-slow animation-delay-4000">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Column - Content -->
                <div class="text-white animate-fade-in-up">
                    <h1 class="text-5xl lg:text-7xl font-bold leading-tight mb-6">
                        Your Service
                        <span class="bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                            Marketplace
                        </span>
                        Awaits
                    </h1>
                    <p class="text-xl lg:text-2xl text-blue-100 mb-8 leading-relaxed">
                        Connect with trusted professionals for all your service needs. From home cleaning to tech
                        support,
                        we've got you covered with verified providers and seamless booking.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 mb-12">
                        <a href="{{ route('register') }}"
                            class="bg-white text-blue-600 px-8 py-4 rounded-full font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 text-center">
                            🚀 Start Booking Services
                        </a>
                        <a href="#how-it-works"
                            class="glass-effect text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:bg-opacity-20 transition-all duration-300 text-center">
                            📖 Learn How it Works
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold">500+</div>
                            <div class="text-blue-200">Services</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold">10K+</div>
                            <div class="text-blue-200">Happy Customers</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold">4.9★</div>
                            <div class="text-blue-200">Average Rating</div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Visual -->
                <div class="relative animate-slide-in-right">
                    <div class="relative">
                        <!-- Floating Service Cards -->
                        <div class="absolute top-10 left-10 bg-white rounded-2xl p-6 shadow-2xl animate-float">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <span class="text-2xl">🏠</span>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800">House Cleaning</div>
                                    <div class="text-green-600 font-bold">₹1,200</div>
                                </div>
                            </div>
                        </div>

                        <div class="absolute top-32 right-0 bg-white rounded-2xl p-6 shadow-2xl animate-float"
                            style="animation-delay: 1s;">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-2xl">🔧</span>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800">AC Repair</div>
                                    <div class="text-blue-600 font-bold">₹800</div>
                                </div>
                            </div>
                        </div>

                        <div class="absolute bottom-20 left-20 bg-white rounded-2xl p-6 shadow-2xl animate-float"
                            style="animation-delay: 2s;">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <span class="text-2xl">💻</span>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800">Tech Support</div>
                                    <div class="text-purple-600 font-bold">₹600</div>
                                </div>
                            </div>
                        </div>

                        <!-- Central Phone Mockup -->
                        <div
                            class="mx-auto w-80 h-80 bg-gradient-to-br from-white to-gray-100 rounded-3xl shadow-2xl flex items-center justify-center">
                            <div class="text-6xl animate-bounce-slow">📱</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    Why Choose <span
                        class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">ServiceBook?</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Experience the future of service booking with our innovative platform designed for both customers
                    and providers.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="service-card bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-2xl transition-all duration-300">
                    <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mb-6">
                        <span class="text-3xl text-white">⚡</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Instant Booking</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Book services in seconds with our streamlined process. No waiting, no hassle - just quick,
                        efficient booking.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="service-card bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-2xl transition-all duration-300">
                    <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center mb-6">
                        <span class="text-3xl text-white">🛡️</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Verified Providers</h3>
                    <p class="text-gray-600 leading-relaxed">
                        All service providers are thoroughly vetted and verified for your safety and peace of mind.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="service-card bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-2xl transition-all duration-300">
                    <div class="w-16 h-16 bg-purple-600 rounded-2xl flex items-center justify-center mb-6">
                        <span class="text-3xl text-white">💬</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Real-time Chat</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Communicate directly with service providers through our built-in messaging system.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="service-card bg-gradient-to-br from-yellow-50 to-yellow-100 p-8 rounded-2xl transition-all duration-300">
                    <div class="w-16 h-16 bg-yellow-600 rounded-2xl flex items-center justify-center mb-6">
                        <span class="text-3xl text-white">⭐</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Rating System</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Make informed decisions with our comprehensive rating and review system from real customers.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div
                    class="service-card bg-gradient-to-br from-red-50 to-red-100 p-8 rounded-2xl transition-all duration-300">
                    <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center mb-6">
                        <span class="text-3xl text-white">💳</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Secure Payments</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Safe and secure payment processing with multiple payment options for your convenience.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div
                    class="service-card bg-gradient-to-br from-indigo-50 to-indigo-100 p-8 rounded-2xl transition-all duration-300">
                    <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mb-6">
                        <span class="text-3xl text-white">📱</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Mobile-First</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Optimized for mobile devices, book services on-the-go with our responsive design.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Services -->
    <section id="services" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    Popular <span
                        class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Services</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Discover the most requested services on our platform
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div
                    class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 text-center">
                    <div class="text-5xl mb-4">🏠</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Home Cleaning</h3>
                    <p class="text-gray-600 text-sm mb-4">Professional house cleaning</p>
                    <div class="text-2xl font-bold text-blue-600">₹1,200</div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 text-center">
                    <div class="text-5xl mb-4">🔧</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">AC Repair</h3>
                    <p class="text-gray-600 text-sm mb-4">Expert AC maintenance</p>
                    <div class="text-2xl font-bold text-green-600">₹800</div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 text-center">
                    <div class="text-5xl mb-4">💻</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Tech Support</h3>
                    <p class="text-gray-600 text-sm mb-4">Computer & phone repair</p>
                    <div class="text-2xl font-bold text-purple-600">₹600</div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 text-center">
                    <div class="text-5xl mb-4">🎨</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Home Painting</h3>
                    <p class="text-gray-600 text-sm mb-4">Interior & exterior painting</p>
                    <div class="text-2xl font-bold text-orange-600">₹2,500</div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    How It <span
                        class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Works</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Get started in three simple steps
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl text-white font-bold">1</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Browse & Choose</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Browse through hundreds of verified service providers and choose the one that fits your needs
                        and budget.
                    </p>
                </div>

                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl text-white font-bold">2</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Book & Schedule</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Select your preferred time slot and book the service instantly. Pay securely through our
                        platform.
                    </p>
                </div>

                <div class="text-center">
                    <div
                        class="w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl text-white font-bold">3</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Relax & Enjoy</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sit back and relax while our verified professionals take care of your service needs.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="blob absolute top-0 left-0 w-72 h-72 bg-white opacity-10"></div>
            <div class="blob absolute bottom-0 right-0 w-96 h-96 bg-white opacity-10" style="animation-delay: 3s;">
            </div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl lg:text-6xl font-bold text-white mb-6">
                Ready to Get Started?
            </h2>
            <p class="text-xl lg:text-2xl text-blue-100 mb-12 leading-relaxed">
                Join thousands of satisfied customers and trusted service providers on ServiceBook today.
            </p>

            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('register') }}"
                    class="bg-white text-blue-600 px-10 py-4 rounded-full font-bold text-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                    🚀 Join as Customer
                </a>
                <a href="{{ route('register') }}"
                    class="glass-effect text-white px-10 py-4 rounded-full font-bold text-xl hover:bg-white hover:bg-opacity-20 transition-all duration-300">
                    💼 Become a Provider
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-2 mb-4">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-xl">S</span>
                    </div>
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                        ServiceBook
                    </span>
                </div>
                <p class="text-gray-400 mb-6">
                    Connecting service providers with customers across India
                </p>
                <div class="text-gray-500 text-sm">
                    © 2025 ServiceBook. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('bg-white', 'shadow-lg');
                navbar.classList.remove('bg-transparent');
            } else {
                navbar.classList.add('bg-transparent');
                navbar.classList.remove('bg-white', 'shadow-lg');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>