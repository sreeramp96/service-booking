<x-app-layout>
    <div class="max-w-lg mx-auto mt-10 bg-white shadow-md rounded px-8 pt-6 pb-8">
        <h2 class="text-2xl font-bold mb-6">Add Availability for {{ $service->name }}</h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('services.availabilities.store', $service) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                <input type="date" name="date" class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Start Time</label>
                <input type="time" name="start_time" class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">End Time</label>
                <input type="time" name="end_time" class="w-full px-3 py-2 border rounded" required>
            </div>

            <a href="{{ route('services.availabilities.index', $service) }}"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                ← Back
            </a>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Save Slot
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
