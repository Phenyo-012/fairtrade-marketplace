<x-app-layout>

<div class="max-w-5xl mx-auto py-10 px-4">

<!-- BACK TO CHAT INDEX -->
    <a href="{{ route('admin.chats.index') }}" class="text-blue-500 hover:underline">
        Back to Chats
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