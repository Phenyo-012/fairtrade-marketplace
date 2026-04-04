<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4">

        <h2 class="text-2xl font-bold mb-6">
            Order #{{ $order->id }}
        </h2>

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- ITEMS -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h3 class="font-semibold mb-4">Your Items</h3>

            @foreach($items as $item)
                <div class="flex justify-between border-b py-3">
                    <div>
                        <p class="font-medium">{{ $item->product->name }}</p>
                        @if($order->seller_deadline && $order->status !== 'shipped')
                            <div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4 mt-4">
                                You must ship this order within:
                                <span class="countdown font-bold"
                                    data-deadline="{{ $order->seller_deadline }}">
                                </span>
                            </div>
                        @elseif($order->status === 'shipped')
                            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 mt-4">
                                This order has been shipped
                        @endif
                        <p class="text-sm text-gray-500">
                            Qty: {{ $item->quantity }}
                        </p>
                    </div>

                    <p class="font-semibold">
                        R{{ number_format($item->subtotal, 2) }}
                    </p>
                </div>
            @endforeach
        </div>

        <!-- STATUS UPDATE -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-semibold mb-4">Update Status</h3>

            <form method="POST" action="{{ route('seller.orders.updateStatus', $order) }}">
                @csrf
                @method('PATCH')

                <select name="status" class="border rounded p-2 w-full mb-4">
                    <option value="awaiting_shipment">Awaiting shipment</option>
                    <option value="shipped">Shipped</option>
                </select>

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Update Status
                </button>
            </form>
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
                el.innerHTML = "Deadline passed";
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