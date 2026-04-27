<x-app-layout>

<div class="bg-gray-100 min-h-screen py-5">
    <div class="max-w-6xl mx-auto px-4">
        <!-- BACK TO SELLER DASHBOARD -->
        <a href="{{ route('seller.dashboard') }}" class="mt-6 px-4 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                </path>
            </svg>
        </a>

        <h2 class="text-2xl font-bold mb-6">Orders</h2>

        <!-- 
        ========================
            FILTER BAR
        ======================== 
        -->
        <form method="GET" class="flex flex-wrap gap-3 mb-6">

            <input type="text" name="search" placeholder="Search Order ID"
                value="{{ request('search') }}"
                class="border px-3 py-2 rounded-3xl focus:ring focus:ring-blue-300 focus:outline-none">

            <select name="status" class="border rounded-3xl px-3 py-2 focus:ring focus:ring-blue-300 focus:outline-none">
                <option value="">All Status</option>
                @foreach(['pending','awaiting_shipment','shipped','delivered','completed','disputed'] as $status)
                    <option value="{{ $status }}" @selected(request('status') == $status)>
                        {{ ucfirst(str_replace('_',' ', $status)) }}
                    </option>
                @endforeach
            </select>

            <button class="font-semibold tracking-wider bg-black text-white px-4 py-2 rounded-3xl shadow-md">
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
                        @if($order->seller_deadline && $order->status !== 'shipped' && $order->status !== 'delivered' && $order->status !== 'completed' && $order->status !== 'cancelled'  && $order->status !== 'disputed')
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

                        @if($order->is_late)
                            <p class="text-red-600 text-sm mt-1">
                                Late Shipment
                            </p>
                        @endif
                    </div>

                    <span class="text-sm px-3 py-1 rounded-xl bg-gray-200">
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