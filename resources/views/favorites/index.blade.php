<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">❤️ My Favorite Services</h1>
                <p class="text-gray-600">Your saved services for quick access and future bookings.</p>
            </div>

            @if ($favorites->isEmpty())
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <div class="text-6xl mb-4">❤️</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">No Favorites Yet</h3>
                    <p class="text-gray-600 mb-4">Start adding services to your favorites for quick access!</p>
                    <a href="{{ route('services.index') }}"
                        class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        🔍 Browse Services
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($favorites as $favorite)
                        @php
                            $service = $favorite->service;
                            $averageRating = $service->reviews->avg('rating') ?: 0;
                            $reviewsCount = $service->reviews->count();
                        @endphp

                        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                            {{-- Service Header --}}
                            <div class="p-6 pb-4">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $service->name }}</h3>
                                    <form action="{{ route('favorites.destroy', $service) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 transition"
                                            title="Remove from favorites">
                                            💔
                                        </button>
                                    </form>
                                </div>

                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($service->description, 100) }}</p>

                                {{-- Provider Info --}}
                                <div class="flex items-center mb-3">
                                    <div
                                        class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                        {{ strtoupper(substr($service->user->name, 0, 1)) }}
                                    </div>
                                    <span class="ml-2 text-sm text-gray-600">{{ $service->user->name }}</span>
                                </div>

                                {{-- Rating --}}
                                @if ($reviewsCount > 0)
                                    <div class="flex items-center mb-3">
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span
                                                    class="text-sm {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}">⭐</span>
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600">
                                            {{ number_format($averageRating, 1) }} ({{ $reviewsCount }} reviews)
                                        </span>
                                    </div>
                                @endif

                                {{-- Price --}}
                                <div class="text-xl font-bold text-blue-600 mb-4">₹{{ number_format($service->price) }}
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="px-6 pb-6">
                                <div class="flex space-x-2">
                                    <a href="{{ route('services.slots', $service) }}"
                                        class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg text-center hover:bg-blue-700 transition text-sm font-medium">
                                        📅 Book Now
                                    </a>
                                    <a href="{{ route('messages.index', $service) }}"
                                        class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition text-sm">
                                        💬
                                    </a>
                                </div>
                            </div>

                            {{-- Added Date --}}
                            <div class="px-6 pb-4 border-t border-gray-100 pt-3">
                                <p class="text-xs text-gray-500">
                                    Added {{ $favorite->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Browse More --}}
                <div class="text-center mt-8">
                    <a href="{{ route('services.index') }}"
                        class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        🔍 Browse More Services
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
