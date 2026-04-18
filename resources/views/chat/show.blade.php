<x-app-layout>

    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-5xl mx-auto px-4">

            <!-- BACK BUTTON -->
            <div class="mb-6">
                <a href="{{ route('chat.index') }}"
                    class="text-blue-500 hover:text-blue-700 font-semibold">
                    Back to Conversations
                </a>
            </div>

            <!-- HEADER -->
            <div class="bg-white rounded-xl shadow p-6 mb-6 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Conversation</h2>
                    <p class="text-sm text-gray-500">
                        Chat securely with users on the platform
                    </p>
                    <!-- VISIT TERMS OF SERVICE FOR CHAT RULES -->
                    <a href="{{ route('terms') }}#chat"
                        class="text-xs text-blue-500 hover:underline mt-1 inline-block">
                        Chat Terms of Service
                    </a>

                    <div class="text-sm text-gray-400 mt-1">
                        {{ $conversation->updated_at->format('M d, Y - H:i') }} |
                        {{ $conversation->messages->where('sender_id','!=',auth()->id())->whereNull('read_at')->count() }} unread
                    </div>
                </div>
            </div>

            <!-- CHAT CARD -->
            <div class="bg-white rounded-xl shadow flex flex-col h-[600px]">

                <!-- MESSAGES -->
                <div id="chatBox"
                    class="chat-scroll flex-1 rounded-xl p-6 space-y-4 bg-gray-50 overflow-y-auto">

                    @forelse($conversation->messages as $message)

                        @php
                            $isMe = $message->sender_id === auth()->id();

                            // STATUS LOGIC
                            if ($isMe) {
                                if ($message->read_at) {
                                    $status = 'Read';
                                    $statusColor = 'text-blue-500';
                                } else {
                                    $status = 'Delivered';
                                    $statusColor = 'text-gray-400';
                                }
                            }
                        @endphp

                        <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">

                            <div class="max-w-sm md:max-w-md">

                                <!-- MESSAGE BUBBLE -->
                                <div class="
                                    px-4 py-2 rounded-2xl text-sm shadow
                                    {{ $isMe
                                        ? 'bg-blue-500 text-white font-semibold tracking-wider rounded-br-none'
                                        : 'bg-gray-900 text-white font-semibold tracking-wider border rounded-bl-none'
                                    }}">
                                    {{ $message->message }}
                                </div>

                                <!-- META + STATUS -->
                                <div class="text-xs mt-1 flex items-center gap-2 {{ $isMe ? 'justify-end' : '' }}">

                                    <span class="text-gray-400">
                                        {{ $message->created_at->format('H:i') }}
                                    </span>

                                    @if($isMe)
                                        <span class="{{ $statusColor }}">
                                            • {{ $status }}
                                        </span>
                                    @endif

                                </div>

                                <!-- REPORT BUTTON -->
                                @if(!$isMe)
                                    <form method="POST"
                                        action="{{ route('chat.report', $message) }}"
                                        class="mt-1">
                                        @csrf
                                        <button class="text-xs text-red-500 hover:underline">
                                            Report
                                        </button>
                                    </form>
                                @endif

                            </div>

                        </div>

                    @empty
                        <p class="text-center text-gray-400">
                            No messages yet. Start the conversation
                        </p>
                    @endforelse

                </div>

                <!-- INPUT -->
                <div class="rounded-b-xl p-4 bg-white">

                    @if(session('error'))
                        <div class="bg-red-100 text-red-700 p-2 rounded mb-3 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST"
                        action="{{ route('chat.send', $conversation) }}"
                        class="flex gap-3">

                        @csrf

                        <input type="text"
                            name="message"
                            placeholder="Type your message..."
                            class="flex-1 border rounded-full px-4 py-2 focus:ring focus:ring-blue-300 focus:outline-none"
                            required>

                        <button class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-800 transition">
                            Send
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </div>

    <!-- AUTO SCROLL -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const chatBox = document.getElementById('chatBox');

        // Scroll to bottom
        chatBox.scrollTop = chatBox.scrollHeight;

        let scrollTimeout;

        chatBox.addEventListener('scroll', () => {
            chatBox.classList.add('show-scrollbar');

            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                chatBox.classList.remove('show-scrollbar');
            }, 800);
        });

    });
    </script>

</x-app-layout>