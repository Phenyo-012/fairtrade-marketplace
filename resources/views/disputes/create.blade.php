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

    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="text-xl font-bold mb-4">Open Dispute</h2>

        <!-- ORDER INFO -->
        <div class="mb-4 text-sm text-gray-600">
            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>Total:</strong> R{{ number_format($order->total_amount, 2) }}</p>
        </div>

        @if(session('error'))
            <p class="text-red-500 mb-3">{{ session('error') }}</p>
        @endif

        <form method="POST" action="{{ route('disputes.store', $order) }}">
            @csrf

            <label class="block mb-2 font-semibold">Reason</label>

            <textarea name="reason"
                class="w-full border rounded-xl p-3 mb-4"
                rows="5"
                placeholder="Describe the issue..."
                required></textarea>

            <button class="px-4 py-2 bg-white text-black border border-black rounded-3xl hover:bg-red-500 transition shadow-md">
                Submit Dispute
            </button>
        </form>

    </div>

</div>

</x-app-layout>