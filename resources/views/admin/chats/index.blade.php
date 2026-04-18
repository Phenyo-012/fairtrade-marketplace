<x-app-layout>

<div class="max-w-6xl mx-auto py-10 px-4">

    <h1 class="text-2xl font-bold mb-6">All Conversations</h1>

    <div class="bg-white rounded-xl shadow divide-y">

        @foreach($conversations as $conversation)

            @php
                $user1 = $conversation->userOne;
                $user2 = $conversation->userTwo;
                $last = $conversation->lastMessage;
            @endphp

            <a href="{{ route('admin.chats.show', $conversation) }}"
               class="flex justify-between items-center p-4 hover:bg-gray-50">

                <div>
                    <p class="font-semibold">
                        {{ $user1->first_name }} & {{ $user2->first_name }}
                    </p>

                    @if($last)
                        <p class="text-sm text-gray-500 truncate">
                            {{ $last->message }}
                        </p>
                    @endif
                </div>

                <span class="text-xs text-gray-400">
                    {{ $conversation->updated_at->diffForHumans() }}
                </span>

            </a>

        @endforeach

    </div>

    <div class="mt-6">
        {{ $conversations->links() }}
    </div>

</div>

</x-app-layout>