<x-app-layout>
    <div class="max-w-5xl mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Welcome, {{ auth()->user()->name }} 👋</h1>

        {{-- <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">📅 Your Upcoming Bookings</h2>

            @forelse($bookings as $booking)
            <div class="bg-white rounded shadow p-4 mb-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-lg">{{ $booking->service->name }}</p>
                        <p class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($booking->availability->date)->format('F j, Y') }},
                            {{ \Carbon\Carbon::parse($booking->availability->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($booking->availability->end_time)->format('H:i') }}
                        </p>
                    </div>
                    <span class="text-sm font-medium px-3 py-1 rounded-full
                        @if ($booking->status === 'confirmed') bg-green-100 text-green-700
                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-700
                        @else bg-red-100 text-red-700 @endif">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-gray-500">You have no bookings yet. Go ahead and book a service!</p>
            @endforelse
        </div> --}}

        <div class="flex justify-end">
            <a href="{{ route('services.index') }}"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-semibold">
                🔍 Browse Services
            </a>
        </div>
    </div>
</x-app-layout>