<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-8">
            {{-- Welcome Section --}}
            <div
                class="bg-gradient-to-r from-blue-100 to-blue-200 p-6 rounded-lg shadow flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-800 mb-1">
                        Welcome back, {{ auth()->user()->name }} 👋
                    </h1>
                    <p class="text-gray-700 text-sm">Explore services, manage your bookings, and get things done!</p>
                </div>
                <img src="https://www.svgrepo.com/show/330996/calendar-booking-schedule.svg" alt="Booking Illustration"
                    class="h-20 hidden md:block opacity-80">
            </div>

            {{-- Quick Actions Bar --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('services.index') }}"
                    class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-all duration-200 text-center group">
                    <div class="text-3xl mb-2 group-hover:scale-110 transition-transform">🔍</div>
                    <div class="font-semibold text-gray-700">Browse Services</div>
                    <div class="text-xs text-gray-500 mt-1">Find what you need</div>
                </a>

                @if (Route::has('reviews.index'))
                    <a href="{{ route('reviews.index') }}"
                        class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-all duration-200 text-center group">
                        <div class="text-3xl mb-2 group-hover:scale-110 transition-transform">⭐</div>
                        <div class="font-semibold text-gray-700">My Reviews</div>
                        <div class="text-xs text-gray-500 mt-1">Rate your experience</div>
                    </a>
                @else
                    <div class="bg-gray-100 p-4 rounded-lg shadow transition-all duration-200 text-center">
                        <div class="text-3xl mb-2 text-gray-400">⭐</div>
                        <div class="font-semibold text-gray-500">My Reviews</div>
                        <div class="text-xs text-gray-400 mt-1">Coming Soon</div>
                    </div>
                @endif

                @if (Route::has('messages.index'))
                    <a href="{{ route('messages.index') }}"
                        class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-all duration-200 text-center group relative">
                        <div class="text-3xl mb-2 group-hover:scale-110 transition-transform">💬</div>
                        <div class="font-semibold text-gray-700">Messages</div>
                        <div class="text-xs text-gray-500 mt-1">Chat with providers</div>
                        @if (isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                            <span
                                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $unreadMessagesCount }}
                            </span>
                        @endif
                    </a>
                @else
                    <div class="bg-gray-100 p-4 rounded-lg shadow transition-all duration-200 text-center">
                        <div class="text-3xl mb-2 text-gray-400">💬</div>
                        <div class="font-semibold text-gray-500">Messages</div>
                        <div class="text-xs text-gray-400 mt-1">Coming Soon</div>
                    </div>
                @endif

                @if (Route::has('favorites.index'))
                    <a href="{{ route('favorites.index') }}"
                        class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-all duration-200 text-center group">
                        <div class="text-3xl mb-2 group-hover:scale-110 transition-transform">❤️</div>
                        <div class="font-semibold text-gray-700">Favorites</div>
                        <div class="text-xs text-gray-500 mt-1">Saved services</div>
                    </a>
                @else
                    <div class="bg-gray-100 p-4 rounded-lg shadow transition-all duration-200 text-center">
                        <div class="text-3xl mb-2 text-gray-400">❤️</div>
                        <div class="font-semibold text-gray-500">Favorites</div>
                        <div class="text-xs text-gray-400 mt-1">Coming Soon</div>
                    </div>
                @endif
            </div>

            {{-- Dashboard Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="text-4xl text-blue-600">📊</div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-800">{{ $bookings->count() }}</div>
                            <div class="text-gray-600 text-sm">Total Bookings</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="text-4xl text-green-600">✅</div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-800">
                                {{ $bookings->where('status', 'confirmed')->count() }}
                            </div>
                            <div class="text-gray-600 text-sm">Confirmed</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="text-4xl text-yellow-600">⏳</div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-800">
                                {{ $bookings->where('status', 'pending')->count() }}
                            </div>
                            <div class="text-gray-600 text-sm">Pending</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Upcoming Bookings Section --}}
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-blue-800">📅 Your Upcoming Bookings</h2>
                    @if (count($bookings) > 0)
                        <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All →</a>
                    @endif
                </div>

                @forelse ($bookings as $booking)
                    <div
                        class="bg-white rounded-lg shadow-sm p-4 mb-3 border-l-4 border-blue-600 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-semibold text-lg text-gray-800">{{ $booking->service->name }}</p>
                                    <span
                                        class="text-sm font-medium px-3 py-1 rounded-full
                                        @if ($booking->status === 'confirmed') bg-green-100 text-green-700
                                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-700
                                        @else bg-red-100 text-red-700 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>

                                <p class="text-sm text-gray-500 mb-3">
                                    📅 {{ \Carbon\Carbon::parse($booking->availability->date)->format('F j, Y') }}
                                    🕐 {{ \Carbon\Carbon::parse($booking->availability->start_time)->format('H:i') }} –
                                    {{ \Carbon\Carbon::parse($booking->availability->end_time)->format('H:i') }}
                                </p>

                                <div class="flex items-center space-x-3">
                                    <form action="{{ route('bookings.rebook', $booking) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition">
                                            🔄 Book Again
                                        </button>
                                    </form>

                                    @if (Route::has('messages.start'))
                                        <a href="{{ route('messages.start', $booking->service) }}"
                                            class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                            💬 Message Provider
                                        </a>
                                    @else
                                        <button
                                            class="bg-gray-400 text-white px-3 py-1 rounded text-sm cursor-not-allowed"
                                            disabled>
                                            💬 Messages (Coming Soon)
                                        </button>
                                    @endif

                                    @if ($booking->status === 'confirmed' && Route::has('reviews.create'))
                                        @if (!auth()->user()->hasReviewed($booking->id))
                                            <a href="{{ route('reviews.create', $booking) }}"
                                                class="bg-yellow-600 text-white px-3 py-1 rounded text-sm hover:bg-yellow-700 transition">
                                                ⭐ Rate Service
                                            </a>
                                        @else
                                            <span class="text-green-600 text-sm">✅ Reviewed</span>
                                        @endif
                                    @elseif($booking->status === 'confirmed')
                                        <button
                                            class="bg-gray-400 text-white px-3 py-1 rounded text-sm cursor-not-allowed"
                                            disabled>
                                            ⭐ Reviews (Coming Soon)
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-10 bg-white rounded-lg shadow-sm">
                        <div class="text-6xl mb-4">📅</div>
                        <p class="text-lg mb-2">You have no upcoming bookings.</p>
                        <p class="text-sm text-gray-400 mb-4">Ready to book your first service?</p>
                        <a href="{{ route('services.index') }}"
                            class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                            🔍 Browse Services
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Recommended Services Section (if has bookings) --}}
            @if (count($bookings) > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">🎯 Recommended for You</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @if (isset($recommendedServices) && $recommendedServices->isNotEmpty())
                            @foreach ($recommendedServices as $service)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="text-2xl">🔧</div>
                                        @if (Route::has('favorites.toggle'))
                                            <button onclick="toggleFavorite({{ $service->id }})"
                                                class="text-gray-400 hover:text-red-500 transition">
                                                <span id="heart-{{ $service->id }}">
                                                    {{ auth()->user()->hasFavorited($service->id) ? '❤️' : '🤍' }}
                                                </span>
                                            </button>
                                        @else
                                            <span class="text-gray-300">🤍</span>
                                        @endif
                                    </div>
                                    <h4 class="font-semibold">{{ $service->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ Str::limit($service->description, 60) }}</p>
                                    @if ($service->reviews_avg_rating)
                                        <div class="flex items-center mt-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span
                                                    class="text-sm {{ $i <= round($service->reviews_avg_rating) ? 'text-yellow-400' : 'text-gray-300' }}">⭐</span>
                                            @endfor
                                            <span class="ml-1 text-xs text-gray-500">({{ $service->bookings_count }}
                                                bookings)</span>
                                        </div>
                                    @endif
                                    <div class="mt-2 flex justify-between items-center">
                                        <span
                                            class="text-blue-600 font-semibold">₹{{ number_format($service->price) }}</span>
                                        <a href="{{ route('services.slots', $service) }}"
                                            class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                            Book
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- Fallback recommendations --}}
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <div class="text-2xl mb-2">🏠</div>
                                <h4 class="font-semibold">House Cleaning</h4>
                                <p class="text-sm text-gray-600">Based on your booking history</p>
                                <div class="mt-2">
                                    <span class="text-blue-600 font-semibold">₹1,200</span>
                                    <span class="text-xs text-gray-500">avg price</span>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <div class="text-2xl mb-2">🔧</div>
                                <h4 class="font-semibold">AC Maintenance</h4>
                                <p class="text-sm text-gray-600">Popular in your area</p>
                                <div class="mt-2">
                                    <span class="text-blue-600 font-semibold">₹800</span>
                                    <span class="text-xs text-gray-500">avg price</span>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <div class="text-2xl mb-2">💻</div>
                                <h4 class="font-semibold">Computer Repair</h4>
                                <p class="text-sm text-gray-600">Frequently booked together</p>
                                <div class="mt-2">
                                    <span class="text-blue-600 font-semibold">₹600</span>
                                    <span class="text-xs text-gray-500">avg price</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Browse More CTA --}}
            <div class="text-center">
                <a href="{{ route('services.index') }}"
                    class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 shadow-lg font-semibold transition-all duration-200 transform hover:scale-105">
                    🔍 Browse More Services
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Toggle favorite functionality
        async function toggleFavorite(serviceId) {
            try {
                const response = await fetch(`/services/${serviceId}/toggle-favorite`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    // Update heart icon
                    const heartElement = document.getElementById(`heart-${serviceId}`);
                    heartElement.textContent = data.favorited ? '❤️' : '🤍';

                    // Show toast notification (optional)
                    showToast(data.message);
                } else {
                    console.error('Error toggling favorite:', data.message);
                }
            } catch (error) {
                console.error('Network error:', error);
            }
        }

        // Simple toast notification
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className =
                'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-opacity';
            toast.textContent = message;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }
    </script>
</x-app-layout>
