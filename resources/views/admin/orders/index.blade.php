<x-app-layout>

    <div class="max-w-6xl mx-auto py-10">

        <h1 class="text-2xl font-bold mb-6">All Orders</h1>

        <form method="GET" class="bg-white p-4 rounded-xl shadow mb-6 grid md:grid-cols-5 gap-3">

            <!-- SEARCH -->
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Order ID"
                class="border p-2 rounded-xl">

            <!-- STATUS -->
            <select name="status" class="border p-2 rounded-xl">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="awaiting_shipment">Awaiting</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="completed">Completed</option>
                <option value="disputed">Disputed</option>
            </select>

            <!-- READY FOR COMPLETION -->
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="ready" value="1"
                    {{ request('ready') ? 'checked' : '' }}>
                Ready (24h passed)
            </label>

            <!-- FROM -->
            <input type="date"
                name="from"
                value="{{ request('from') }}"
                class="border p-2 rounded-xl">

            <!-- TO -->
            <input type="date"
                name="to"
                value="{{ request('to') }}"
                class="border p-2 rounded-xl">

            <!-- BUTTONS -->
            <button class="bg-blue-600 text-white rounded-xl px-4">
                Filter
            </button>

            <a href="{{ route('admin.orders.index') }}"
            class="text-center bg-gray-200 rounded-xl px-4 py-2">
                Reset
            </a>

        </form>

        @foreach($orders as $order)
            <a href="{{ route('admin.orders.show', $order) }}"
            class="block bg-white p-4 rounded-xl shadow mb-3 hover:bg-gray-50">

                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold">Order #{{ $order->id }}</p>
                        <p class="text-sm text-gray-500">
                            {{ ucfirst($order->status) }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="font-bold">R{{ number_format($order->total_amount, 2) }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $order->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>

            </a>
        @endforeach

        <div class="mt-6">
            {{ $orders->links() }}
        </div>

    </div>

</x-app-layout>