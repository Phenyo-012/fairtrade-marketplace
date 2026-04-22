<x-app-layout>
    
    <div class="max-w-6xl mx-auto py-5 px-4">

        <a href="{{ route('admin.dashboard') }}" class="mt-6 px-4 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                </path>
            </svg>
        </a>

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