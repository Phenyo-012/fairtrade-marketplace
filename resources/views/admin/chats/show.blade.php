<x-app-layout>

<div class="max-w-5xl mx-auto py-5 px-4">

<!-- BACK TO CHAT INDEX -->
    <a href="{{ route('admin.chats.index') }}" class="mt-6 px-4 py-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
            </path>
        </svg>
    </a>

    <h2 class="text-xl font-bold mb-4">
        Conversation (Admin View)
    </h2>

    <div class="bg-white rounded-xl shadow p-6 space-y-4 h-[600px] overflow-y-auto">

        @foreach($conversation->messages as $message)

            <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">

                <div class="max-w-md">

                    <div class="px-4 py-2 rounded-lg
                        {{ $message->sender_id === auth()->id()
                            ? 'bg-blue-500 text-white'
                            : 'bg-gray-200'
                        }}">
                        {{ $message->message }}
                    </div>

                    <div class="text-xs text-gray-400 mt-1">
                        {{ $message->sender->first_name }} {{ $message->sender->last_name }} • {{ $message->sender->email }} • {{ $message->created_at->format('H:i') }}
                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

</x-app-layout>