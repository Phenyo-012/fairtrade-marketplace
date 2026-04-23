<x-app-layout>

    <div class="bg-gray-100 min-h-screen py-5">
        <div class="max-w-5xl mx-auto px-4">

            <!-- BACK TO CHATS -->
            <a href="{{ route('chat.index') }}" class="mt-6 px-4 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                    </path>
                </svg>
            </a>


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
                        Messaging & Communication Policy
                    </a>
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

                            <div class="max-w-sm md:max-w-md w-fit min-w-0">

                                <!-- MESSAGE BUBBLE -->
                                <div class="px-4 py-2 rounded-3xl text-sm shadow
                                    {{ $isMe ? 'bg-blue-500 text-white font-semibold tracking-wider rounded-br-none'
                                            : 'bg-black text-white font-semibold tracking-wider border rounded-bl-none' }}"
                                    style="overflow-wrap: anywhere; word-break: break-word;">
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

                        <button class="bg-black text-white px-3 py-3 rounded-full hover:bg-blue-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M12 21l0 -17.5" />
                                    <path d="M12 3l7 7M12 3l-7 7" />
                                </g>
                            </svg>
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