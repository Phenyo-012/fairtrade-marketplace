<x-app-layout>

    <div class="bg-gray-100 min-h-screen py-5">
        <div class="max-w-7xl mx-auto px-4">

            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                     <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                     </path>
                  </svg>
            </a>

            <!-- HEADER -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Disputes</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Review and manage buyer and seller dispute cases.
                    </p>
                </div>
            </div>

            <!-- SUMMARY CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-5 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Total Disputes</p>
                    <h3 class="text-2xl font-bold">{{ $disputes->count() }}</h3>
                </div>

                <div class="bg-white p-5 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Open</p>
                    <h3 class="text-2xl font-bold text-red-600">
                        {{ $disputes->where('status', 'open')->count() }}
                    </h3>
                </div>

                <div class="bg-white p-5 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Under Review</p>
                    <h3 class="text-2xl font-bold text-orange-500">
                        {{ $disputes->where('status', 'under_review')->count() }}
                    </h3>
                </div>

                <div class="bg-white p-5 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Resolved</p>
                    <h3 class="text-2xl font-bold text-green-600">
                        {{ $disputes->where('status', 'resolved')->count() }}
                    </h3>
                </div>
            </div>

            <!-- DISPUTES TABLE -->
            <div class="bg-white rounded-xl shadow overflow-hidden">

                <div class="px-6 py-4 border-b flex items-center justify-between">
                    <h3 class="font-bold text-gray-800">All Disputes</h3>

                    <span class="text-sm text-gray-500">
                        {{ $disputes->count() }} record(s)
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr class="text-left text-gray-600">
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Order</th>
                                <th class="px-6 py-4">Opened By</th>
                                <th class="px-6 py-4">Reason</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Created</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($disputes as $dispute)
                                <tr class="border-b hover:bg-gray-50 transition">

                                    <td class="px-6 py-4 font-semibold">
                                        #{{ $dispute->id }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.disputes.show', $dispute) }}"
                                           class="text-blue-600 hover:underline font-medium">
                                            Order #{{ $dispute->order->id ?? 'N/A' }}
                                        </a>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-800">
                                            {{ $dispute->openedBy->first_name ?? $dispute->openedBy->name ?? 'User' }}
                                            {{ $dispute->openedBy->last_name ?? '' }}
                                        </div>

                                        <div class="text-xs text-gray-400">
                                            {{ $dispute->openedBy->email ?? 'No email' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 max-w-xs">
                                        <p class="text-gray-700 line-clamp-2">
                                            {{ $dispute->reason }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($dispute->status === 'open')
                                            <span class="bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">
                                                Open
                                            </span>
                                        @elseif($dispute->status === 'under_review')
                                            <span class="bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1 rounded-full">
                                                Under Review
                                            </span>
                                        @elseif($dispute->status === 'resolved')
                                            <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                                                Resolved
                                            </span>
                                        @else
                                            <span class="bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-1 rounded-full">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $dispute->created_at?->diffForHumans() }}
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.disputes.show', $dispute) }}"
                                           class="inline-block bg-black text-white px-4 py-2 rounded-3xl hover:bg-gray-800 transition">
                                            View
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                        No disputes found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- PAGINATION IF PAGINATED -->
            @if(method_exists($disputes, 'links'))
                <div class="mt-6">
                    {{ $disputes->links() }}
                </div>
            @endif

        </div>
    </div>

</x-app-layout>