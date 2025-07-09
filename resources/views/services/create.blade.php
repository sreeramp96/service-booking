<x-app-layout>
    <div class="max-w-lg mx-auto mt-10">
        <h1 class="text-xl font-bold mb-4">Add New Service</h1>
        <form action="{{ route('services.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium">Service Name</label>
                <input type="text" name="name" class="w-full mt-1 border px-3 py-2 rounded"
                    value="{{ old('name') }}" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Description</label>
                <textarea name="description" rows="3" class="w-full mt-1 border px-3 py-2 rounded">{{ old('description') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium">Price (₹)</label>
                <input type="number" name="price" step="0.01" class="w-full mt-1 border px-3 py-2 rounded"
                    value="{{ old('price') }}" required>
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create</button>
        </form>
    </div>
</x-app-layout>
