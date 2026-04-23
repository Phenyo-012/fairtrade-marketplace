<x-app-layout>

    <div class="bg-gray-100 min-h-screen py-5">

        <div class="max-w-7xl mx-auto px-4">

             <!-- BACK TO ADMIN DASHBOARD -->
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                    </path>
                </svg>
            </a>


            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold">Support Tickets</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Review and manage support requests submitted by users.
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-4 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Name, email, subject..." class="w-full border border-gray-300 
                            rounded-3xl p-3">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-3xl p-3">
                            <option value="">All Statuses</option>
                            <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Category</label>
                        <select name="category" class="w-full border border-gray-300 rounded-3xl p-3">
                            <option value="">All Categories</option>
                            <option value="general" {{ request('category') === 'general' ? 'selected' : '' }}>General</option>
                            <option value="order" {{ request('category') === 'order' ? 'selected' : '' }}>Order Issue</option>
                            <option value="payment" {{ request('category') === 'payment' ? 'selected' : '' }}>Payment / Escrow</option>
                            <option value="seller" {{ request('category') === 'seller' ? 'selected' : '' }}>Seller Issue</option>
                            <option value="buyer" {{ request('category') === 'buyer' ? 'selected' : '' }}>Buyer Issue</option>
                            <option value="account" {{ request('category') === 'account' ? 'selected' : '' }}>Account</option>
                            <option value="technical" {{ request('category') === 'technical' ? 'selected' : '' }}>Technical Problem</option>
                            <option value="dispute" {{ request('category') === 'dispute' ? 'selected' : '' }}>Dispute</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button class="bg-black text-white px-5 py-3 rounded-3xl hover:bg-gray-800 transition shadow-md">
                            Apply
                        </button>

                        <a href="{{ route('admin.support.index') }}"
                           class="px-5 py-3 rounded-3xl border border-gray-300 bg-white hover:bg-gray-100 transition shadow-md">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr class="text-left">
                                <th class="p-4">ID</th>
                                <th class="p-4">User</th>
                                <th class="p-4">Subject</th>
                                <th class="p-4">Category</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Submitted</th>
                                <th class="p-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-4 font-semibold">#{{ $ticket->id }}</td>
                                    <td class="p-4">
                                        <div class="font-medium">{{ $ticket->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $ticket->email }}</div>
                                    </td>
                                    <td class="p-4">
                                        <div class="font-medium">{{ $ticket->subject }}</div>
                                        <div class="text-xs text-gray-500 line-clamp-1">
                                            {{ \Illuminate\Support\Str::limit($ticket->message, 60) }}
                                        </div>
                                    </td>
                                    <td class="p-4 capitalize">
                                        {{ str_replace('_', ' ', $ticket->category) }}
                                    </td>
                                    <td class="p-4">
                                        <span class="text-xs px-3 py-1 rounded-full
                                            {{ $ticket->status === 'open' ? 'bg-red-100 text-red-700' : '' }}
                                            {{ $ticket->status === 'in_progress' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                            {{ $ticket->status === 'resolved' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $ticket->status === 'closed' ? 'bg-gray-200 text-gray-700' : '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-500">
                                        {{ $ticket->created_at->diffForHumans() }}
                                    </td>
                                    <td class="p-4">
                                        <a href="{{ route('admin.support.show', $ticket) }}"
                                           class="bg-white text-black px-4 py-2 border border-gray-400 rounded-3xl text-xs hover:bg-blue-300 shadow-md">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-6 text-center text-gray-500">
                                        No support tickets found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4">
                    {{ $tickets->links() }}
                </div>
            </div>

        </div>
    </div>

</x-app-layout>