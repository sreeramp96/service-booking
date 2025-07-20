<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            {{-- Header --}}
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('messages.index') }}" class="text-blue-600 hover:text-blue-700">
                            ← Back to Messages
                        </a>
                        <div
                            class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr($otherParticipant->name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">{{ $otherParticipant->name }}</h1>
                            @if ($conversation->service)
                                <p class="text-sm text-blue-600">{{ $conversation->service->name }}</p>
                            @endif
                        </div>
                    </div>

                    @if ($conversation->service)
                        <a href="{{ route('services.slots', $conversation->service) }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                            📅 Book Service
                        </a>
                    @endif
                </div>
            </div>

            {{-- Messages Container --}}
            <div class="bg-white rounded-lg shadow">
                {{-- Messages List --}}
                <div class="h-96 overflow-y-auto p-6 space-y-4" id="messages-container">
                    @forelse($messages as $message)
                        <div class="flex {{ $message->isFromUser(auth()->id()) ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs lg:max-w-md">
                                <div
                                    class="rounded-lg px-4 py-2 {{ $message->isFromUser(auth()->id()) ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800' }}">
                                    <p class="text-sm">{{ $message->message }}</p>
                                </div>
                                <p
                                    class="text-xs text-gray-500 mt-1 {{ $message->isFromUser(auth()->id()) ? 'text-right' : 'text-left' }}">
                                    {{ $message->created_at->format('M j, g:i A') }}
                                    @if ($message->isFromUser(auth()->id()) && $message->read_at)
                                        <span class="text-blue-600">✓ Read</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-8">
                            <div class="text-4xl mb-2">💬</div>
                            <p>No messages yet. Start the conversation!</p>
                        </div>
                    @endforelse
                </div>

                {{-- Message Input --}}
                <div class="border-t border-gray-100 p-6">
                    <form action="{{ route('messages.store', $conversation) }}" method="POST" id="message-form">
                        @csrf
                        <div class="flex space-x-4">
                            <div class="flex-1">
                                <input type="text" name="message" id="message-input"
                                    placeholder="Type your message..."
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>
                            <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                                Send 📤
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-scroll to bottom on page load
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('messages-container');
            container.scrollTop = container.scrollHeight;

            // Focus message input
            document.getElementById('message-input').focus();
        });

        // Handle form submission
        document.getElementById('message-form').addEventListener('submit', function(e) {
            const messageInput = document.getElementById('message-input');
            if (!messageInput.value.trim()) {
                e.preventDefault();
                return;
            }

            // Clear input after sending
            setTimeout(() => {
                messageInput.value = '';
            }, 100);
        });

        // Auto-refresh messages every 10 seconds (basic polling)
        setInterval(function() {
            fetch(window.location.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    // Simple way to update messages - in production, use more sophisticated approach
                    const parser = new DOMParser();
                    const newDoc = parser.parseFromString(html, 'text/html');
                    const newMessages = newDoc.getElementById('messages-container');
                    if (newMessages) {
                        const currentContainer = document.getElementById('messages-container');
                        const wasAtBottom = currentContainer.scrollTop + currentContainer.clientHeight >=
                            currentContainer.scrollHeight - 10;

                        currentContainer.innerHTML = newMessages.innerHTML;

                        if (wasAtBottom) {
                            currentContainer.scrollTop = currentContainer.scrollHeight;
                        }
                    }
                })
                .catch(error => console.log('Error refreshing messages:', error));
        }, 10000);
    </script>
</x-app-layout>
