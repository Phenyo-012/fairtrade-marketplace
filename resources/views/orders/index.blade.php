<x-app-layout>

<div class="max-w-6xl mx-auto px-4 py-10">

    <h2 class="text-2xl font-bold mb-6">My Orders</h2>

    <!-- FILTER BAR -->
    <form method="GET" class="flex flex-wrap gap-3 mb-6">

        <input type="text" name="search" placeholder="Search Order ID"
               value="{{ request('search') }}"
               class="border rounded-3xl px-3 py-2 focus:ring focus:ring-blue-300 focus:outline-none">

        <select name="status" class="border rounded-3xl px-3 py-2 focus:ring focus:ring-blue-300 focus:outline-none">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="awaiting_shipment">Awaiting Shipment</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
            <option value="completed">Completed</option>
            <option value="disputed">Disputed</option>
        </select>

        <button class="font-semibold tracking-wider bg-black text-white px-4 py-2 rounded-3xl">
            Filter
        </button>

    </form>

    <!-- ORDERS GRID -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($orders as $order)

        <a href="{{ route('orders.show', $order) }}"
           class="block bg-white p-5 rounded-xl shadow hover:shadow-lg transition">

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-3">
                <span class="font-bold">#{{ $order->id }}</span>

                <span class="text-sm font-semibold
                    @switch($order->status)
                        @case('pending') text-gray-500 @break
                        @case('awaiting_shipment') text-blue-500 @break
                        @case('shipped') text-orange-500 @break
                        @case('delivered') text-green-600 @break
                        @case('completed') text-green-800 @break
                        @case('disputed') text-red-600 @break
                    @endswitch
                ">
                    {{ ucfirst(str_replace('_',' ', $order->status)) }}
                </span>
            </div>

            <!-- DELIVERY CODE -->
            <p class="text-sm text-gray-600">
                Code: <span class="font-bold text-green-700">{{ $order->delivery_code }}</span>
            </p>

            <!-- PROGRESS BAR -->
            <div class="w-full bg-gray-200 rounded-xl h-2 mt-3">
                <div class="bg-green-500 h-2 rounded-xl"
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

            <!-- FOOTER -->
            <div class="mt-4 text-sm text-gray-500">
                {{ $order->created_at->format('d M Y') }}
            </div>

        </a>

        @empty
            <p>No orders found.</p>
        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="mt-8">
        {{ $orders->links() }}
    </div>

</div>

</x-app-layout>