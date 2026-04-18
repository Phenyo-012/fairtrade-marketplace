<x-app-layout>

    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-6xl mx-auto px-4">

            <h2 class="text-2xl font-bold mb-6">
                Order #{{ $order->id }}
            </h2>

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- GLOBAL STATUS ALERTS (SHOW ONLY ONCE) --}}
            @if($order->is_late && $order->status !== 'shipped')
                <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4">
                    This order is late! Please ship it as soon as possible.
                </div>
            @endif

            @if($order->status === 'shipped')
                <div class="bg-green-100 text-green-800 p-3 rounded-xl mb-4">
                    This order has been shipped
                </div>
            @endif

            @if($order->seller_deadline && !in_array($order->status, ['shipped','delivered','completed','cancelled','disputed']))
                <div class="bg-yellow-100 text-black p-3 rounded-xl mb-4">
                    You must ship this order within:
                    <span class="countdown font-bold"
                        data-deadline="{{ $order->seller_deadline }}">
                    </span>
                </div>
            @endif

            <!-- MAIN GRID -->
            <div class="grid md:grid-cols-3 gap-6">

                <!-- ITEMS -->
                <div class="md:col-span-2 bg-white rounded-xl shadow p-6">
                    <h3 class="font-semibold mb-4">Your Items</h3>

                    @foreach($order->orderItems as $item)
                        <div class="flex items-center justify-between border-b py-4 gap-4">

                            <!-- LEFT: IMAGE + INFO -->
                            <div class="flex items-center gap-4">

                                <!-- PRODUCT IMAGE -->
                                @if($item->product->images && $item->product->images->count())
                                    <img 
                                        src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                        alt="{{ $item->product->name }}"
                                        class="w-16 h-16 object-cover rounded-lg"
                                    >
                                @else
                                    <img 
                                        src="/placeholder.png"
                                        alt="No image"
                                        class="w-16 h-16 object-cover rounded-lg"
                                    >
                                @endif

                                <!-- PRODUCT DETAILS -->
                                <div>
                                    <p class="font-medium">
                                        {{ $item->product->name }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Qty: {{ $item->quantity }}
                                    </p>
                                </div>

                            </div>

                            <!-- RIGHT: PRICE -->
                            <p class="font-semibold">
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

                    <div class="bg-white border border-gray-200 p-6 rounded-xl shadow mb-6 mt-6">
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
                </div>

                <!-- STATUS PANEL -->
                <div class="bg-white rounded-xl shadow p-6 h-fit">
                    <h3 class="font-semibold mb-4">Update Status</h3>

                    <form method="POST" action="{{ route('seller.orders.updateStatus', $order) }}">
                        @csrf
                        @method('PATCH')

                        <select name="status" class="border rounded-3xl p-2 w-full mb-4 focus:ring-blue-300 focus:outline-none">
                            <option value="awaiting_shipment"
                                {{ $order->status === 'awaiting_shipment' ? 'selected' : '' }}>
                                Awaiting shipment
                            </option>

                            <option value="shipped"
                                {{ $order->status === 'shipped' ? 'selected' : '' }}>
                                Shipped
                            </option>
                        </select>

                        <button class="w-full font-semibold bg-blue-300 hover:bg-gray-300 text-black py-2 border border-gray-300 rounded-3xl mt-3 shadow-md">
                            Update Status
                        </button>
                    </form>
                </div>

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

                    el.classList.remove('text-green-600','text-yellow-600','text-red-600');

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