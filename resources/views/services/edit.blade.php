<x-app-layout>
    <div class="max-w-lg mx-auto mt-10">
        <h1 class="text-xl font-bold mb-4">Edit Service</h1>
        <form action="{{ route('services.update', $service->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium">Service Name</label>
                <input type="text" name="name" class="w-full mt-1 border px-3 py-2 rounded"
                    value="{{ old('name', $service->name) }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Description</label>
                <textarea name="description" rows="3" class="w-full mt-1 border px-3 py-2 rounded">{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Price (₹)</label>
                <input type="number" name="price" step="0.01" class="w-full mt-1 border px-3 py-2 rounded"
                    value="{{ old('price', $service->price) }}" required>
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
        </form>
    </div>
</x-app-layout>
