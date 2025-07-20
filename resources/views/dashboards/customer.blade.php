<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto space-y-8">
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

            <div>
                <h2 class="text-xl font-semibold text-blue-800 mb-4">📅 Your Upcoming Bookings</h2>

                @forelse ($bookings as $booking)
                    <div class="bg-white rounded-lg shadow-sm p-4 mb-3 border-l-4 border-blue-600">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-lg text-gray-800">{{ $booking->service->name }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($booking->availability->date)->format('F j, Y') }},
                                    {{ \Carbon\Carbon::parse($booking->availability->start_time)->format('H:i') }} –
                                    {{ \Carbon\Carbon::parse($booking->availability->end_time)->format('H:i') }}
                                </p>
                            </div>
                            <span
                                class="text-sm font-medium px-3 py-1 rounded-full
                                            @if ($booking->status === 'confirmed') bg-green-100 text-green-700
                                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-700
                                            @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-10 bg-white rounded-lg shadow-sm">
                        <p class="mb-2">You have no upcoming bookings.</p>
                        <a href="{{ route('services.index') }}"
                            class="inline-block mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition font-semibold">
                            🔍 Browse Services
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- 🔍 CTA Button --}}
            @if (count($bookings) > 0)
                <div class="text-right">
                    <a href="{{ route('services.index') }}"
                        class="inline-flex items-center bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 shadow font-semibold transition">
                        🔍 Browse More Services
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
