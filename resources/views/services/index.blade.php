<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">My Services</h1>
            @auth
                @if (auth()->user()->role === 'provider')
                    <a href="{{ route('services.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Add Service
                    </a>
                @endif
            @endauth
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded p-4">
            @forelse($services as $service)
                <div class="mb-4 border-b pb-2">
                    <h2 class="text-lg font-semibold">{{ $service->name }}</h2>
                    <p class="text-sm text-gray-600">{{ $service->description }}</p>
                    <p class="text-sm mt-1">₹{{ $service->price }}</p>
                    <div class="mt-2 flex gap-2">
                        <a href="{{ route('services.edit', $service->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('services.destroy', $service->id) }}" method="POST"
                            onsubmit="return confirm('Delete this service?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">You haven't added any services yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>