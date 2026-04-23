<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\ChatReport;

class ChatController extends Controller
{
    public function start($sellerId)
    {
        $userId = auth()->id();

        if ($userId == $sellerId) {
            abort(403);
        }

        // Prevent blocked users
        if (\DB::table('user_blocks')
            ->where('blocker_id', $sellerId)
            ->where('blocked_id', $userId)
            ->exists()) {
            return back()->with('error', 'You cannot message this user');
        }

        // Ensure consistent order (avoid duplicates)
        $ids = collect([$userId, $sellerId])->sort()->values();

        $conversation = \App\Models\Conversation::firstOrCreate([
            'user_one_id' => $ids[0],
            'user_two_id' => $ids[1],
        ]);

        return redirect()->route('chat.show', $conversation);
    }

    public function show(Conversation $conversation)
    {
        if (!in_array(auth()->id(), [$conversation->user_one_id, $conversation->user_two_id])
            && !auth()->user()->hasRole('admin')) {
            abort(403);
        }

        // MARK AS READ
        \App\Models\Message::where('conversation_id', $conversation->id)
            ->where('sender_id', '!=', auth()->id())
            ->whereNull('read_at')
            ->update([
                'read_at' => now()
            ]);

        $conversation->load([
            'messages' => function ($q) {
                $q->orderBy('created_at', 'asc');
            }
        ]);

        return view('chat.show', compact('conversation'));
    }

    public function send(Request $request, Conversation $conversation)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        // RATE LIMIT (anti-spam)
        $lastMessage = \App\Models\Message::where('sender_id', auth()->id())
            ->latest()
            ->first();

        if ($lastMessage && $lastMessage->created_at->diffInSeconds(now()) < 3) {
            return back()->with('error', 'You are sending messages too fast.');
        }

        \App\Models\Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'message' => $request->message
        ]);

        $conversation->touch(); // Update conversation's updated_at for sorting

        return back();
    }

    public function report(Request $request, Message $message)
    {
        \App\Models\ChatReport::create([
            'message_id' => $message->id,
            'reported_by' => auth()->id(),
            'reason'  => $request->reason ?? 'Feature Not available'
        ]);

        $message->update(['is_flagged' => true]);

        return back()->with('success', 'Message reported');
    }

    public function block($userId)
    {
        \DB::table('user_blocks')->insertOrIgnore([
            'blocker_id' => auth()->id(),
            'blocked_id' => $userId
        ]);

        return back()->with('success', 'User blocked');
    }

    public function index()
    {
        $userId = auth()->id();

        $conversations = \App\Models\Conversation::where(function ($q) use ($userId) {
                $q->where('user_one_id', $userId)
                ->orWhere('user_two_id', $userId);
            })
            ->with([
                'userOne.sellerProfile',
                'userTwo.sellerProfile',
                'lastMessage',
                'messages' => function ($q) {
                    $q->select('id', 'conversation_id', 'sender_id', 'read_at');
                }
            ])
            ->latest('updated_at')
            ->get();

        return view('chat.index', compact('conversations'));
    }
}
