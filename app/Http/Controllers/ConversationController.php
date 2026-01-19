<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $conversations = Conversation::where('initiator_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->with([
                'initiator',
                'recipient',
                'donation',
                'messages' => function ($query) {
                    $query->latest()->limit(1);
                }
            ])
            ->latest('last_message_at')
            ->paginate(15);

        return view('conversations.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $this->authorizeAccess($conversation);

        $messages = $conversation->messages()
            ->with('sender')
            ->oldest()
            ->get();

        // Mark messages as read
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('conversations.show', compact('conversation', 'messages'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        $this->authorizeAccess($conversation);

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        $conversation->update(['last_message_at' => now()]);

        return back()->with('success', 'Message envoyé.');
    }

    public function start(Donation $donation)
    {
        $initiatorId = Auth::id();
        $recipientId = $donation->donor_id;

        if ($initiatorId == $recipientId) {
            return back()->with('error', 'Vous ne pouvez pas démarrer une conversation avec vous-même.');
        }

        $conversation = Conversation::firstOrCreate([
            'donation_id' => $donation->id,
            'initiator_id' => $initiatorId,
            'recipient_id' => $recipientId,
        ], [
            'status' => 'active',
            'last_message_at' => now(),
        ]);

        return redirect()->route('conversations.show', $conversation);
    }

    private function authorizeAccess(Conversation $conversation)
    {
        if ($conversation->initiator_id !== Auth::id() && $conversation->recipient_id !== Auth::id()) {
            abort(403);
        }
    }
}
