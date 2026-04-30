<x-app-layout>

    <div class="max-w-5xl mx-auto px-4 py-5">

        <!-- BACK TO MY ORDERS -->
        <a href="{{ route('orders.my') }}" class="mt-6 px-4 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                </path>
            </svg>
        </a>


        <h2 class="text-2xl font-bold mb-6">
            Order #{{ $order->id }}
        </h2>

        <!-- STATUS + TIMELINE -->
        <div class="bg-white p-6 rounded-xl shadow mb-6">

            <p class="font-semibold mb-2">
                Status:
                <span class="text-blue-600">
                    {{ ucfirst(str_replace('_',' ', $order->status)) }}
                </span>
            </p>

            <p class="mb-2">
                Delivery Code:
                <span class="font-bold text-green-700">
                    {{ $order->delivery_code }}
                </span>
            </p>

            <p class="mb-4">
                Ordered on: {{ $order->created_at->format('d M Y H:i') }}
            </p>

            @if($order->can_buyer_cancel)
                <div class="bg-yellow-100 text-yellow-900 p-4 rounded-xl shadow mb-6">
                    <p class="font-semibold mb-1">
                        You can still cancel this order.
                    </p>
                    <p class="text-sm mb-3">
                        Time left:
                        <span
                            class="buyer-cancel-countdown font-bold"
                            data-deadline="{{ $order->buyer_cancellation_deadline }}">
                        </span>
                    </p>

                    <form method="POST" action="{{ route('orders.cancel', $order) }}">
                        @csrf
                        @method('PATCH')

                        <button class="bg-red-500 text-white px-4 py-2 rounded-3xl hover:bg-red-600 shadow-md">
                            Cancel Order
                        </button>
                    </form>
                </div>
            @endif

            @if(!$order->can_buyer_cancel && in_array($order->status, ['pending', 'awaiting_shipment']))
                <div class="bg-gray-100 text-red-600 p-4 rounded-xl shadow mb-6">
                    The buyer cancellation window has expired.
                </div>
            @endif

            <!-- TIMELINE -->
            <div class="flex justify-between text-sm">

                @php
                    $steps = [
                        'pending' => 'Order Placed',
                        'awaiting_shipment' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'completed' => 'Completed'
                    ];

                    $currentIndex = array_search($order->status, array_keys($steps));
                @endphp

                @foreach($steps as $key => $label)
                    <div class="flex-1 text-center">
                        <div class="w-6 h-6 mx-auto rounded-full
                            {{ array_search($key, array_keys($steps)) <= $currentIndex 
                                ? 'bg-blue-500' : 'bg-gray-300' }}">
                        </div>
                        <p class="mt-2 text-xs">{{ $label }}</p>
                    </div>
                @endforeach

            </div>

        </div>

        <!-- ITEMS -->
        <div class="bg-white p-6 rounded-xl shadow mb-6">

            <h3 class="font-bold mb-4">Items</h3>

            @foreach($order->orderItems as $item)

            <div class="flex items-center justify-between border-b py-4 gap-4">

                <!-- LEFT -->
                <div class="flex items-center gap-4">

                    <!-- CLICKABLE IMAGE -->
                    <a href="/products/{{ $item->product->id }}" class="block w-20 h-20 rounded-xl overflow-hidden">
                        @if($item->product->images->count())
                            <img 
                                src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                class="w-20 h-20 object-cover rounded-xl hover:scale-105 transition"
                            >
                        @else
                            <img src="/placeholder.png"
                                class="w-20 h-20 object-cover rounded-xl">
                        @endif
                    </a>

                    <!-- DETAILS -->
                    <div>

                        <!-- PRODUCT NAME (CLICKABLE) -->
                        <a href="/products/{{ $item->product->id }}"
                        class="font-semibold text-gray-800 hover:text-blue-600">
                            {{ $item->product->name }}
                        </a>

                        <p class="text-sm text-gray-500">
                            Quantity: {{ $item->quantity }}
                        </p>

                        <!-- SELLER -->
                        <p class="text-xs text-gray-400">
                            Sold by:
                            <a href="/store/{{ $item->product->sellerProfile->id }}"
                            class="underline hover:text-blue-600">
                                {{ $item->product->sellerProfile->store_name }}
                            </a>
                        </p>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="text-right">

                    <p class="font-bold text-gray-900">
                       @php
                            $price = $item->unit_price;
                        @endphp

                        @if($item->product->discount_percentage && $item->product->discount_ends_at && now()->lt($item->product->discount_ends_at))
                            <div>
                                <span class="font-bold text-black ml-2">
                                    R{{ number_format($price * $item->quantity, 2) }}
                                </span>
                                <span class="line-through text-gray-400">
                                    R{{ number_format($item->product->price * $item->quantity, 2) }}
                                </span>
                            </div>
                        @else
                             <span class="font-bold text-black ml-2">
                                    R{{ number_format($price * $item->quantity, 2) }}
                                </span>
                                <span class="line-through text-gray-400">
                                    R{{ number_format($item->product->price * $item->quantity, 2) }}
                                </span>
                        @endif
                    </p>

                    <!-- BUY AGAIN -->
                    <form method="GET" action="/products/{{ $item->product->id }}">
                        @csrf
                        <input type="hidden" name="quantity" value="1">

                        <button class="font-semibold tracking-wider mt-2 text-xs bg-gray-200 border border-gray-400 px-3 py-3 rounded-3xl hover:bg-blue-300 shadow-md">
                            Buy Again
                        </button>
                    </form>

                </div>

            </div>

            @endforeach

        </div>

        <!-- SHIPPING DETAILS -->
        <div class="bg-white p-6 rounded-xl shadow mb-6">       
            <h3 class="font-bold mb-3">Shipping Details</h3>

            <label class="text-md text-gray-500">Recipient:</label>
            <p>{{ $order->shipping_name }}</p>
            <label class="text-md text-gray-500">Phone:</label>
            <p>{{ $order->shipping_phone }}</p>
            <label class="text-md text-gray-500">Address:</label>
            <p>{{ $order->shipping_address }}</p>
            <label class="text-md text-gray-500">City:</label>
            <p>{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
            <label class="text-md text-gray-500">Province:</label>
            <p>{{ $order->shipping_province }}</p>
            <label class="text-md text-gray-500">Country:</label>
            <p>{{ $order->shipping_country }}</p>

            @if($order->courier_tracking_number)
                <p class="mt-3 font-semibold text-blue-600">
                    Tracking #: {{ $order->courier_tracking_number }}
                </p>
            @endif
        </div>

        <!-- TOTAL -->
        <div class="bg-white p-6 rounded-xl shadow mb-6">

            @php
                $itemsTotal = $order->orderItems->sum('subtotal');
                $shippingFee = $order->shipping_fee ?? 0;
            @endphp

            <h3 class="font-bold mb-4">Payment Summary</h3>

            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Items Total</span>
                    <span>R{{ number_format($itemsTotal, 2) }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Shipping Fee</span>
                    <span>R{{ number_format($shippingFee, 2) }}</span>
                </div>

                <div class="border-t pt-3 mt-3 flex justify-between text-lg font-bold">
                    <span>Total</span>
                    <span>R{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

        </div>

        <!-- ACTIONS -->
        <div class="flex flex-wrap gap-4">

            @if($order->dispute)
                <a href="{{ route('disputes.show', $order->dispute) }}"
                class="px-4 py-2 bg-white text-black border border-black rounded-3xl hover:bg-blue-600 transition shadow-md">
                    View Dispute
                </a>

            @elseif($order->status !== 'disputed')
                <a href="{{ route('disputes.create', $order) }}"
                class="px-4 py-2 bg-white text-black border border-black rounded-3xl hover:bg-red-500 transition shadow-md">
                    Dispute Order
                </a>
            @endif

            @php
                $reviewableItems = $order->orderItems->filter(function ($item) {
                    return $item->reviews->where('buyer_id', auth()->id())->count() === 0;
                });
            @endphp

            @if($reviewableItems->count() > 0)
                <a href="{{ route('reviews.create', $order) }}"
                class="px-4 py-2 bg-white text-black border border-black rounded-3xl hover:bg-green-600 transition shadow-md">
                    Write Review
                </a>
            @else
                <span class="text-green-600 font-bold mt-2">
                    Review Submitted
                </span>
            @endif
        </div>

    </div>

    <!-- ORDER CANCELLATION COUNTDOWN SCRIPT -->
    <script>
        function startBuyerCancelCountdowns() {
            const elements = document.querySelectorAll('.buyer-cancel-countdown');

            elements.forEach(el => {
                const deadline = new Date(el.dataset.deadline).getTime();

                function update() {
                    const now = new Date().getTime();
                    const diff = deadline - now;

                    if (diff <= 0) {
                        el.innerHTML = "Expired";

                        const cancelBox = el.closest('.bg-yellow-100, .bg-orange-100');
                        if (cancelBox) {
                            setTimeout(() => window.location.reload(), 1000);
                        }
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