<x-app-layout>

<div class="max-w-5xl mx-auto py-10">

    <h1 class="text-2xl font-bold mb-6">
        Admin View - Order #{{ $order->id }}
    </h1>

    <!-- ORDER INFO -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">

        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Total:</strong> R{{ number_format($order->total_amount, 2) }}</p>
        <p><strong>Delivery Code:</strong> {{ $order->delivery_code }}</p>
        <p><strong>Placed:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>

        <hr class="my-4">

        <!--- SHIPPING DETAILS -->
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

    <!-- ITEMS -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">

        <h2 class="font-bold mb-4">Order Items</h2>

        @foreach($order->orderItems as $item)

            <div class="flex items-center gap-4 border-b py-3">

                <!-- PRODUCT IMAGE -->
                <img src="{{ $item->product->images->first()
                    ? asset('storage/'.$item->product->images->first()->image_path)
                    : '/placeholder.png' }}"
                    class="w-16 h-16 object-cover rounded-xl">

                <div class="flex-1">
                    <p class="font-semibold">{{ $item->product->name }}</p>
                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                </div>

                <p class="font-bold">
                    @php
                        $price = $item->unit_price;
                    @endphp

                    @if($item->product->discount_percentage && $item->product->discount_ends_at && now()->lt($item->product->discount_ends_at))
                        <span class="font-bold text-black ml-2">
                            R{{ number_format($price * $item->quantity, 2) }}
                        </span>
                        <span class="line-through text-gray-400">
                            R{{ number_format($item->product->price * $item->quantity, 2) }}
                        </span>
                    @else
                        <span class="font-bold text-black ml-2">
                            R{{ number_format($price * $item->quantity, 2) }}
                        </span>
                        <span class="line-through text-gray-400">
                            R{{ number_format($item->product->price * $item->quantity, 2) }}
                        </span>
                    @endif
                </p>

            </div>

        @endforeach

    </div>

    <!-- ADMIN ACTIONS -->
    <div class="bg-white p-6 rounded-xl shadow">

        <h2 class="font-bold mb-4">Admin Actions</h2>

        @if($order->canBeCompletedByAdmin())

            <form method="POST" action="{{ route('admin.orders.complete', $order) }}">
                @csrf
                @method('PATCH')

                <button class="bg-green-600 text-white px-4 py-2 rounded-xl">
                    Complete Order
                </button>
            </form>

        @else

            <p class="text-gray-500">
                ⏳ Order cannot be completed yet (24 hour rule not met)
            </p>

        @endif

    </div>

</div>

</x-app-layout>