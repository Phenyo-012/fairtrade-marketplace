<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;

class AdminChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with([
                'userOne',
                'userTwo',
                'lastMessage'
            ])
            ->latest('updated_at')
            ->paginate(20);

        return view('admin.chats.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $conversation->load([
            'messages.sender',
            'userOne.sellerProfile',
            'userTwo.sellerProfile'
        ]);

        return view('admin.chats.show', compact('conversation'));
    }
}