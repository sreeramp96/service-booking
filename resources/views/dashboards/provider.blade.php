<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 px-4 space-y-6">
        <div class="bg-gradient-to-r from-green-100 to-green-200 p-6 rounded shadow flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Hello, {{ auth()->user()->name }} 👋</h1>
                <p class="text-sm text-gray-700">Welcome to your provider dashboard</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Your Services</h2>
                <a href="{{ route('services.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">+ Add Service</a>
            </div>

            @if ($services->isEmpty())
                <p class="text-gray-500">You haven't added any services yet.</p>
            @else
                <ul class="divide-y">
                    @foreach ($services as $service)
                        <li class="py-4">
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-lg font-semibold">{{ $service->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $service->description }}</p>
                                    <p class="text-sm text-gray-800 mt-1">₹{{ $service->price }}</p>
                                </div>
                                <div class="flex gap-4 items-center text-sm">
                                    <a href="{{ route('services.availabilities.index', $service) }}">📅 Slots</a>
                                    <a href="{{ route('services.edit', $service->id) }}"
                                        class="text-yellow-600 hover:underline">✏️ Edit</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
