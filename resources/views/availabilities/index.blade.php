<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6">Availability for: {{ $service->name }}</h1>

        <div class="flex justify-end mb-4">
            <a href="{{ route('services.availabilities.create', $service) }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Add Availability
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded p-4">
            @forelse($availabilities as $slot)
                <div class="border-b pb-3 mb-3">
                    <p><strong>Date:</strong> {{ $slot->date }}</p>
                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500">No availability added yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>