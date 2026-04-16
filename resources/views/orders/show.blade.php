<x-app-layout>

    <div class="max-w-5xl mx-auto px-4 py-10">

        <h2 class="text-2xl font-bold mb-6">
            Order #{{ $order->id }}
        </h2>

        <!-- 
        ========================
            STATUS + TIMELINE
        ======================== 
        -->
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
                                ? 'bg-green-500' : 'bg-gray-300' }}">
                        </div>
                        <p class="mt-2 text-xs">{{ $label }}</p>
                    </div>
                @endforeach

            </div>

        </div>

        <!-- 
        ========================
            ITEMS
        ======================== 
        -->
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
                        R{{ number_format($item->subtotal, 2) }}
                    </p>

                    <!-- BUY AGAIN -->
                    <form method="GET" action="/products/{{ $item->product->id }}">
                        @csrf
                        <input type="hidden" name="quantity" value="1">

                        <button class="mt-2 text-xs bg-gray-100 px-3 py-1 rounded hover:bg-gray-200">
                            Buy Again
                        </button>
                    </form>

                </div>

            </div>

            @endforeach

        </div>

        <!-- 
        ========================    
            SHIPPING DETAILS
        ======================== 
        -->
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
            <label class="text-md text-gray-500">Country:</label>
            <p>{{ $order->shipping_country }}</p>

            @if($order->tracking_number)
                <p class="mt-3 font-semibold text-blue-600">
                    Tracking #: {{ $order->tracking_number }}
                </p>
            @endif
        </div>

        <!-- 
        ========================
            TOTAL
        ======================== 
        -->
        <div class="bg-white p-6 rounded-xl shadow mb-6">

            <p class="text-lg font-bold">
                Total: R{{ number_format($order->total_amount, 2) }}
            </p>

        </div>

        <!-- ========================
            ACTIONS
        ======================== -->
        <div class="flex flex-wrap gap-4">

            @if($order->dispute)
                <a href="{{ route('disputes.show', $order->dispute) }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    View Dispute
                </a>

            @elseif($order->status !== 'disputed')
                <a href="{{ route('disputes.create', $order) }}"
                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Dispute Order
                </a>
            @endif

            @if($order->canBeReviewed())
                <a href="{{ route('reviews.create', $order) }}"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Write Review
                </a>

            @elseif($order->review)
                <span class="text-green-600 font-bold">
                    Review Submitted
                </span>
            @endif

        </div>

    </div>

</x-app-layout>