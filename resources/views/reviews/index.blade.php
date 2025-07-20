<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">⭐ My Reviews</h1>
                <p class="text-gray-600">See all the reviews you've written for services you've used.</p>
            </div>

            @if ($reviews->isEmpty())
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <div class="text-6xl mb-4">⭐</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">No Reviews Yet</h3>
                    <p class="text-gray-600 mb-4">Start reviewing services you've used to help other customers!</p>
                    <a href="{{ route('customer.dashboard') }}"
                        class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        🏠 Back to Dashboard
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($reviews as $review)
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $review->service->name }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Reviewed on {{ $review->created_at->format('F j, Y') }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                class="text-lg {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">⭐</span>
                                        @endfor
                                    </div>
                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm"
                                            onclick="return confirm('Are you sure you want to delete this review?')">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            </div>

                            @if ($review->rating_categories)
                                <div class="grid grid-cols-3 gap-4 mb-4">
                                    @foreach ($review->rating_categories as $category => $rating)
                                        <div class="text-center">
                                            <div class="text-sm text-gray-600 capitalize">{{ $category }}</div>
                                            <div class="flex justify-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span
                                                        class="text-sm {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}">⭐</span>
                                                @endfor
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if ($review->comment)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-700">{{ $review->comment }}</p>
                                </div>
                            @endif

                            @if ($review->is_anonymous)
                                <div class="mt-2">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">
                                        🕶️ Anonymous Review
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
