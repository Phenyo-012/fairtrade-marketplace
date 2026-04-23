<x-app-layout>

    <div class="max-w-6xl mx-auto mt-5 px-4">

        <h2 class="text-2xl font-bold mb-6">My Orders</h2>

        <!-- FILTER BAR -->
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

        <!-- ORDERS GRID -->
        <div class="grid md:grid-cols-2 gap-6">

            @forelse($orders as $order)

            <a href="{{ route('orders.show', $order) }}"
            class="block bg-white p-5 rounded-xl shadow hover:shadow-lg transition">

                <!-- HEADER -->
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold">Order #{{ $order->id }}</h3>

                    <span class="text-sm font-semibold
                        @if($order->status == 'pending') text-gray-500
                        @elseif($order->status == 'awaiting_shipment') text-blue-500
                        @elseif($order->status == 'shipped') text-orange-500
                        @elseif($order->status == 'delivered') text-green-600
                        @elseif($order->status == 'completed') text-green-800
                        @elseif($order->status == 'disputed') text-red-600
                        @endif
                    ">
                        {{ ucfirst(str_replace('_',' ', $order->status)) }}
                    </span>
                </div>

                <!-- PRODUCTS PREVIEW -->
                <div class="flex gap-2 mb-3">
                    @foreach($order->orderItems->take(3) as $item)
                        <img src="{{ $item->product->images->first()
                            ? asset('storage/'.$item->product->images->first()->image_path)
                            : '/placeholder.png' }}"
                            class="w-12 h-12 object-cover rounded-xl">
                    @endforeach
                </div>

                <!-- DELIVERY CODE -->
                <p class="text-sm text-gray-600">
                    Code: <span class="font-bold text-green-700">{{ $order->delivery_code }}</span>
                </p>

                <!-- PROGRESS BAR -->
                <div class="w-full bg-gray-200 rounded-xl h-2 mt-3">
                    <div class="bg-blue-500 h-2 rounded-xl"
                        style="width:
                            @switch($order->status)
                                @case('pending') 10% @break
                                @case('awaiting_shipment') 30% @break
                                @case('shipped') 60% @break
                                @case('delivered') 90% @break
                                @case('completed') 100% @break
                                @default 0%
                            @endswitch;">
                    </div>
                </div>

            </a>

            @empty
                <p>No orders found.</p>
            @endforelse

        </div>

        <!-- PAGINATION -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>

    </div>

</x-app-layout>