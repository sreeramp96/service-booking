<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6">Available Slots for {{ $service->name }}</h1>

        @if (session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @forelse($slots as $slot)
            <div class="bg-white p-4 rounded shadow mb-3 flex justify-between items-center">
                <div>
                    <p><strong>Date:</strong> {{ $slot->date }}</p>
                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</p>
                </div>
                <form action="{{ route('services.book', [$service->id, $slot->id]) }}" method="POST">
                    @csrf
                    <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Book</button>
                </form>
            </div>
        @empty
            <p class="text-gray-500">No slots available for this service right now.</p>
        @endforelse
    </div>
</x-app-layout>
