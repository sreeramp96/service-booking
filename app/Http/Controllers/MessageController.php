<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Service;
use App\Models\User;

class MessageController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $conversations = Conversation::where('customer_id', $user->id)
            ->orWhere('provider_id', $user->id)
            ->with(['customer', 'provider', 'service', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $user = auth()->user();

        // Check if user is part of this conversation
        if ($conversation->customer_id !== $user->id && $conversation->provider_id !== $user->id) {
            abort(403);
        }

        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        $otherParticipant = $conversation->getOtherParticipant($user->id);

        return view('messages.show', compact('conversation', 'messages', 'otherParticipant'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $user = auth()->user();

        // Check permissions
        if ($conversation->customer_id !== $user->id && $conversation->provider_id !== $user->id) {
            abort(403);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'message' => $request->message
        ]);

        // Update conversation's last message time
        $conversation->update(['last_message_at' => now()]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message->load('sender'),
                'success' => true
            ]);
        }

        return redirect()->back();
    }

    public function create(Request $request)
    {
        $serviceId = $request->get('service_id');
        $providerId = $request->get('provider_id');

        $service = Service::findOrFail($serviceId);
        $provider = User::findOrFail($providerId);

        // Check if conversation already exists
        $conversation = Conversation::where('customer_id', auth()->id())
            ->where('provider_id', $providerId)
            ->where('service_id', $serviceId)
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'customer_id' => auth()->id(),
                'provider_id' => $providerId,
                'service_id' => $serviceId,
                'last_message_at' => now()
            ]);
        }

        return redirect()->route('messages.show', $conversation);
    }

    public function startConversation(Service $service)
    {
        $user = auth()->user();
        $provider = $service->user;

        // Don't allow provider to message themselves
        if ($user->id === $provider->id) {
            return redirect()->back()->with('error', 'You cannot message yourself.');
        }

        // Find or create conversation
        $conversation = Conversation::firstOrCreate([
            'customer_id' => $user->id,
            'provider_id' => $provider->id,
            'service_id' => $service->id
        ], [
            'last_message_at' => now()
        ]);

        return redirect()->route('messages.show', $conversation);
    }
}
