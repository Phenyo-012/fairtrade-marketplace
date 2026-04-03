<x-app-layout>

<div class="max-w-2xl mx-auto py-10 px-4">

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
                class="w-full border rounded p-3 mb-4"
                rows="5"
                placeholder="Describe the issue..."
                required></textarea>

            <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Submit Dispute
            </button>
        </form>

    </div>

</div>

</x-app-layout>