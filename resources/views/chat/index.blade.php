<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-3xl mx-auto px-4">

        <h2 class="text-2xl font-bold mb-6">Messages</h2>

        <div class="bg-white rounded-xl shadow divide-y">

            @forelse($conversations as $conversation)

                @php
                    $other = $conversation->otherUser();
                    $isSeller = $other->sellerProfile ?? null;

                    $name = $isSeller
                        ? $isSeller->store_name
                        : $other->first_name . ' ' . $other->last_name;

                    $avatar = $isSeller && $isSeller->logo
                        ? asset('storage/' . $isSeller->logo)
                        : ($other->profile_photo_url ?? asset('images/default-user.png'));

                    $lastMessage = $conversation->lastMessage;

                    $unreadCount = $conversation->messages
                        ->where('sender_id', '!=', auth()->id())
                        ->whereNull('read_at')
                        ->count();
                @endphp

                <a href="{{ route('chat.show', $conversation) }}"
                   class="flex items-center gap-4 p-4 hover:bg-gray-50 transition">

                    <!-- PROFILE IMAGE -->
                    <img src="{{ $avatar }}"
                         class="w-12 h-12 rounded-full object-cover">

                    <!-- TEXT -->
                    <div class="flex-1">

                        <div class="flex justify-between items-center">
                            <h3 class="font-semibold {{ $unreadCount ? 'font-bold text-black' : '' }}">
                                {{ $name }}
                            </h3>

                            @if($lastMessage)
                                <span class="text-xs text-gray-400">
                                    {{ $lastMessage->created_at->diffForHumans() }}
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">

                            @if($lastMessage)
                                <span class="text-xs text-gray-400">
                                    {{ $lastMessage->created_at->diffForHumans() }}
                                </span>
                            @endif

                            @if($unreadCount > 0)
                                <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $unreadCount }}
                                </span>
                            @endif

                        </div>

                        <p class="text-sm truncate {{ $unreadCount ? 'text-black font-medium' : 'text-gray-500' }}">
                            {{ $lastMessage->message ?? 'No messages yet' }}
                        </p>

                    </div>

                </a>

            @empty
                <p class="p-6 text-center text-gray-400">
                    No conversations yet
                </p>
            @endforelse

        </div>

    </div>
</div>

</x-app-layout>