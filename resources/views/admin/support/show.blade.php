<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-5">
        <div class="max-w-5xl mx-auto px-4">

            <div class="mb-6">
                <!-- BACK TO SUPPORT TICKETS -->
                <a href="{{ route('admin.support.index') }}" class="px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                        </path>
                    </svg>
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <h1 class="text-2xl font-bold">
                                Ticket #{{ $ticket->id }}
                            </h1>
                            <p class="text-gray-500 text-sm mt-1">
                                Submitted {{ $ticket->created_at->format('d M Y H:i') }}
                            </p>
                        </div>

                        <span class="text-xs px-3 py-1 rounded-full
                            {{ $ticket->status === 'open' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $ticket->status === 'in_progress' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $ticket->status === 'resolved' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $ticket->status === 'closed' ? 'bg-gray-200 text-gray-700' : '' }}">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                    </div>

                    <div class="mb-5">
                        <h2 class="font-semibold text-lg mb-2">Subject</h2>
                        <p class="text-gray-800">{{ $ticket->subject }}</p>
                    </div>

                    <div>
                        <h2 class="font-semibold text-lg mb-2">Message</h2>
                        <div class="bg-gray-50 border rounded-xl p-4 text-gray-700 whitespace-pre-line"
                            style="overflow-wrap: anywhere; word-break: break-word;">
                            {{ $ticket->message }}
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow p-6">
                        <h2 class="font-semibold text-lg mb-4">User Details</h2>

                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-gray-500">Name</p>
                                <p class="font-medium">{{ $ticket->name }}</p>
                            </div>

                            <div>
                                <p class="text-gray-500">Email</p>
                                <p class="font-medium">{{ $ticket->email }}</p>
                            </div>

                            <div>
                                <p class="text-gray-500">Category</p>
                                <p class="font-medium capitalize">
                                    {{ str_replace('_', ' ', $ticket->category) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500">Account Linked</p>
                                <p class="font-medium">
                                    {{ $ticket->user_id ? 'Yes' : 'No' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow p-6">
                        <h2 class="font-semibold text-lg mb-4">Update Status</h2>

                        <form method="POST" action="{{ route('admin.support.updateStatus', $ticket) }}" class="space-y-4">
                            @csrf
                            @method('PATCH')

                            <select name="status" class="w-full border border-gray-300 rounded-xl p-3">
                                <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>

                            @error('status')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror

                            <button class="w-full bg-black text-white py-3 rounded-3xl hover:bg-gray-800 transition">
                                Save Status
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>