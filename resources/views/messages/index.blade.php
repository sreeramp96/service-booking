<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">💬 Messages</h1>
                <p class="text-gray-600">Your conversations with service providers.</p>
            </div>

            @if ($conversations->isEmpty())
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <div class="text-6xl mb-4">💬</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">No Conversations Yet</h3>
                    <p class="text-gray-600 mb-4">Start a conversation with a service provider!</p>
                    <a href="{{ route('services.index') }}"
                        class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        🔍 Browse Services
                    </a>
                </div>
            @else
                <div class="bg-white rounded-lg shadow">
                    @foreach ($conversations as $conversation)
                        @php
                            $otherParticipant = $conversation->getOtherParticipant(auth()->id());
                            $latestMessage = $conversation->latestMessage;
                            $hasUnread = $conversation->hasUnreadMessages(auth()->id());
                        @endphp

                        <a href="{{ route('messages.show', $conversation) }}"
                            class="block border-b border-gray-100 hover:bg-gray-50 transition">
                            <div class="p-6">
                                <div class="flex items-center space-x-4">
                                    {{-- Avatar --}}
                                    <div
                                        class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($otherParticipant->name, 0, 1)) }}
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-semibold text-gray-800 truncate">
                                                {{ $otherParticipant->name }}
                                                @if ($hasUnread)
                                                    <span
                                                        class="ml-2 w-2 h-2 bg-blue-600 rounded-full inline-block"></span>
                                                @endif
                                            </h3>
                                            <span class="text-sm text-gray-500">
                                                {{ $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : '' }}
                                            </span>
                                        </div>

                                        @if ($conversation->service)
                                            <p class="text-sm text-blue-600 mb-1">{{ $conversation->service->name }}</p>
                                        @endif

                                        @if ($latestMessage)
                                            <p class="text-sm text-gray-600 truncate">
                                                {{ $latestMessage->isFromUser(auth()->id()) ? 'You: ' : '' }}
                                                {{ Str::limit($latestMessage->message, 60) }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Unread Indicator --}}
                                    @if ($hasUnread)
                                        <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">!</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
