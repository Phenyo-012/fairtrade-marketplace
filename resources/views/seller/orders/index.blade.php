<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-6xl mx-auto px-4">

        <h2 class="text-2xl font-bold mb-6">Orders</h2>

        <form method="GET" class="mb-6 flex flex-wrap gap-3">

            <!-- SEARCH -->
            <input type="text"
                name="search"
                placeholder="Order ID"
                value="{{ request('search') }}"
                class="border rounded px-3 py-2">

            <!-- STATUS FILTER -->
            <select name="status" class="border rounded px-3 py-2">
                <option value="">All Status</option>
                <option value="pending" @selected(request('status')=='pending')>Pending</option>
                <option value="awaiting_shipment" @selected(request('status')=='awaiting_shipment')>Awaiting Shipment</option>
                <option value="shipped" @selected(request('status')=='shipped')>Shipped</option>
                <option value="delivered" @selected(request('status')=='delivered')>Delivered</option>
                <option value="completed" @selected(request('status')=='completed')>Completed</option>
                <option value="cancelled" @selected(request('status')=='cancelled')>Cancelled</option>
                <option value="disputed" @selected(request('status')=='disputed')>Disputed</option>
            </select>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Filter
            </button>

        </form>

        @forelse($orders as $order)
            <a href="{{ route('seller.orders.show', $order) }}"
            class="block bg-white p-4 rounded-xl shadow mb-4 hover:shadow-md transition">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="font-semibold">Order #{{ $order->id }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $order->created_at->format('d M Y') }}
                        </p>

                        {{-- TIMER --}}
                        @if($order->seller_deadline && $order->status !== 'shipped')
                            <p class="text-sm mt-1">
                                 Ship within:
                                <span class="countdown font-bold"
                                    data-deadline="{{ $order->seller_deadline }}">
                                </span>
                            </p>
                        @elseif($order->status === 'shipped')
                            <p class="text-green-600 text-sm mt-1">
                                 Shipped
                            </p>
                        @endif
                    </div>

                    <span class="text-sm px-3 py-1 rounded bg-gray-200">
                        {{ ucfirst($order->status) }}
                    </span>

                </div>

            </a>
        @empty
            <p>No orders found.</p>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>

    </div>
</div>

<script>
function startCountdowns() {
    const elements = document.querySelectorAll('.countdown');

    elements.forEach(el => {
        const deadline = new Date(el.dataset.deadline).getTime();

        function update() {
            const now = new Date().getTime();
            const diff = deadline - now;

            if (diff <= 0) {
                el.innerHTML = " Deadline passed";
                el.classList.add('text-red-600');
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            el.innerHTML = `${hours}h ${minutes}m ${seconds}s`;

            // Color logic
            if (hours < 6) {
                el.classList.add('text-red-600');
            } else if (hours < 24) {
                el.classList.add('text-yellow-600');
            } else {
                el.classList.add('text-green-600');
            }
        }

        update();
        setInterval(update, 1000);
    });
}

document.addEventListener('DOMContentLoaded', startCountdowns);
</script>

</x-app-layout>