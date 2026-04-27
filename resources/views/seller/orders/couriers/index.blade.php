<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-2">
        <div class="max-w-6xl mx-auto px-4">

             <!-- BACK TO ORDER -->
            <a href="{{ route('seller.orders.show', $order) }}" class="px-4 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                    </path>
                </svg>
            </a>

            <div class="bg-white p-6 rounded-xl shadow mt-2 mb-6">
                <h1 class="text-2xl font-bold">Choose Courier</h1>
                <p class="text-gray-500 text-sm mt-1">
                    Order #{{ $order->id }} — simulated courier API booking.
                </p>
            </div>

            @if($order->can_buyer_cancel)
                <div class="bg-orange-100 text-orange-900 p-4 rounded-xl shadow mb-6">
                    Buyer can still cancel this order. Courier booking is locked until:
                    <span class="buyer-cancel-countdown font-bold"
                          data-deadline="{{ $order->buyer_cancellation_deadline }}"></span>
                </div>
            @endif

            <div class="grid md:grid-cols-2 gap-6">
                @foreach($couriers as $key => $courier)
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-xl font-bold">{{ $courier['name'] }}</h2>
                        <p class="text-gray-600 text-sm mt-2">
                            {{ $courier['description'] }}
                        </p>

                        <div class="mt-4 space-y-2">
                            @foreach($courier['services'] as $service)
                                <div class="border rounded-xl p-3 text-sm">
                                    <p class="font-semibold">{{ $service['name'] }}</p>
                                    <p class="text-gray-500">{{ $service['days'] }}</p>
                                    <p class="font-bold">R{{ number_format($service['fee'], 2) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <a href="{{ route('seller.orders.couriers.show', [$order, $key]) }}"
                           class="block text-center mt-5 bg-black text-white py-3 rounded-3xl hover:bg-gray-800">
                            Open Courier API
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <script>
        function startBuyerCancelCountdowns() {
            document.querySelectorAll('.buyer-cancel-countdown').forEach(el => {
                const deadline = new Date(el.dataset.deadline).getTime();

                function update() {
                    const now = new Date().getTime();
                    const diff = deadline - now;

                    if (diff <= 0) {
                        el.innerHTML = 'Expired';
                        setTimeout(() => window.location.reload(), 1000);
                        return;
                    }

                    const minutes = Math.floor(diff / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                    el.innerHTML = `${minutes}m ${seconds}s`;
                }

                update();
                setInterval(update, 1000);
            });
        }

        document.addEventListener('DOMContentLoaded', startBuyerCancelCountdowns);
    </script>
</x-app-layout>