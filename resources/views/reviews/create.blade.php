<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">⭐ Rate Your Experience</h1>

                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-blue-800">{{ $booking->service->name }}</h3>
                    <p class="text-sm text-blue-600">
                        Service Date: {{ \Carbon\Carbon::parse($booking->availability->date)->format('F j, Y') }}
                    </p>
                    <p class="text-sm text-blue-600">
                        Provider: {{ $booking->service->user->name }}
                    </p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('reviews.store', $booking) }}">
                    @csrf

                    {{-- Overall Rating --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Overall Rating *</label>
                        <div class="flex items-center space-x-1" id="overall-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button"
                                    class="star-btn text-3xl text-gray-300 hover:text-yellow-400 transition"
                                    data-rating="{{ $i }}" data-group="overall">
                                    ⭐
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-input" required>
                    </div>

                    {{-- Detailed Ratings --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detailed Ratings (Optional)</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- Quality --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quality</label>
                                <div class="flex items-center space-x-1" id="quality-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button"
                                            class="star-btn text-lg text-gray-300 hover:text-yellow-400 transition"
                                            data-rating="{{ $i }}" data-group="quality">
                                            ⭐
                                        </button>
                                    @endfor
                                </div>
                                <input type="hidden" name="quality_rating" id="quality-input">
                            </div>

                            {{-- Punctuality --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Punctuality</label>
                                <div class="flex items-center space-x-1" id="punctuality-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button"
                                            class="star-btn text-lg text-gray-300 hover:text-yellow-400 transition"
                                            data-rating="{{ $i }}" data-group="punctuality">
                                            ⭐
                                        </button>
                                    @endfor
                                </div>
                                <input type="hidden" name="punctuality_rating" id="punctuality-input">
                            </div>

                            {{-- Value --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Value for Money</label>
                                <div class="flex items-center space-x-1" id="value-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="button"
                                            class="star-btn text-lg text-gray-300 hover:text-yellow-400 transition"
                                            data-rating="{{ $i }}" data-group="value">
                                            ⭐
                                        </button>
                                    @endfor
                                </div>
                                <input type="hidden" name="value_rating" id="value-input">
                            </div>
                        </div>
                    </div>

                    {{-- Comment --}}
                    <div class="mb-6">
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                            Your Review (Optional)
                        </label>
                        <textarea name="comment" id="comment" rows="4"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Share your experience with this service..."></textarea>
                    </div>

                    {{-- Anonymous Option --}}
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_anonymous" value="1" class="rounded">
                            <span class="ml-2 text-sm text-gray-700">Post this review anonymously</span>
                        </label>
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="flex justify-between">
                        <a href="{{ route('customer.dashboard') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle star ratings
            document.querySelectorAll('.star-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    const group = this.dataset.group;

                    // Update hidden input
                    document.getElementById(group + (group === 'overall' ? '' : '-') + 'input')
                        .value = rating;

                    // Update star colors
                    const container = document.getElementById(group + '-rating');
                    const stars = container.querySelectorAll('.star-btn');

                    stars.forEach((star, index) => {
                        if (index < rating) {
                            star.classList.remove('text-gray-300');
                            star.classList.add('text-yellow-400');
                        } else {
                            star.classList.remove('text-yellow-400');
                            star.classList.add('text-gray-300');
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
