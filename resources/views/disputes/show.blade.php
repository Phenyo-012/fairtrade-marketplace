<x-app-layout>

    <div class="max-w-2xl mx-auto py-5 px-4">

        <!-- BACK TO MY ORDERS -->
        <a href="{{ route('orders.my') }}" class="mt-6 px-4 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                </path>
            </svg>
        </a>

        <h2 class="text-2xl font-bold mb-6">Dispute Details</h2>

        <div class="bg-white p-6 rounded-xl shadow space-y-4">

            <p>
                <strong>Order ID:</strong> {{ $dispute->order_id }}
            </p>

            <p>
                <strong>Status:</strong>
                @if($dispute->status === 'open')
                    <span class="text-orange-500 font-semibold">Open</span>
                @elseif($dispute->status === 'resolved')
                    <span class="text-green-600 font-semibold">Resolved</span>
                @elseif($dispute->status === 'rejected')
                    <span class="text-red-600 font-semibold">Rejected</span>
                @endif
            </p>

            <p>
                <strong>Reason:</strong>
            </p>
            <p class="bg-gray-100 p-3 rounded-xl">
                {{ $dispute->reason }}
            </p>
            @if($dispute->seller_response)
                <p><strong>Seller Response:</strong></p>
                <p class="bg-yellow-100 p-3 rounded-xl">
                    {{ $dispute->seller_response }}
                </p>
            @endif

            @if($dispute->status !== 'open')
                <p>
                    <strong>Resolution Notes:</strong>
                </p>
                <p class="bg-blue-50 p-3 rounded-xl">
                    {{ $dispute->resolution_notes ?? 'No notes provided.' }}
                </p>

                <p>
                    <strong>Resolved At:</strong>
                    {{ $dispute->updated_at->format('d M Y H:i') }}
                </p>
            @endif

        </div>

    </div>

</x-app-layout>