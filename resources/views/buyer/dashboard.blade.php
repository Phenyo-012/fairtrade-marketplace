<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4">

            <!-- HEADER -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Buyer Dashboard
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Track your orders, deliveries, spending, wishlist, and disputes.
                    </p>
                </div>

                <a href="{{ route('marketplace.index') }}"
                   class="bg-black text-white px-5 py-3 rounded-3xl shadow hover:bg-gray-800 text-center">
                    Continue Shopping
                </a>
            </div>

            <!-- STAT CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

                <div class="bg-white rounded-xl shadow p-5">
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <h2 class="text-3xl font-bold mt-2">{{ $totalOrders }}</h2>
                </div>

                <div class="bg-white rounded-xl shadow p-5">
                    <p class="text-sm text-gray-500">Completed Spend</p>
                    <h2 class="text-3xl font-bold mt-2">
                        R{{ number_format($totalSpent, 2) }}
                    </h2>
                </div>

                <div class="bg-white rounded-xl shadow p-5">
                    <p class="text-sm text-gray-500">Active Deliveries</p>
                    <h2 class="text-3xl font-bold mt-2 text-blue-600">
                        {{ $activeDeliveries }}
                    </h2>
                </div>

                <div class="bg-white rounded-xl shadow p-5">
                    <p class="text-sm text-gray-500">Open Disputes</p>
                    <h2 class="text-3xl font-bold mt-2 text-red-600">
                        {{ $openDisputes }}
                    </h2>
                </div>

                <div class="bg-white rounded-xl shadow p-5">
                    <p class="text-sm text-gray-500">Wishlist Items</p>
                    <h2 class="text-3xl font-bold mt-2">
                        {{ $wishlistCount }}
                    </h2>
                </div>

            </div>

            <!-- MAIN GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- LEFT COLUMN -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- ORDER STATUS TRACKER -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-xl font-bold">Order Status Overview</h2>
                            <a href="{{ route('orders.my') }}" class="text-sm text-blue-600 hover:underline">
                                View all orders
                            </a>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($statusCounts as $status => $count)
                                <div class="border rounded-xl p-4 hover:shadow transition">
                                    <p class="text-sm text-gray-500">
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </p>
                                    <p class="text-2xl font-bold mt-1">
                                        {{ $count }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- RECENT ORDERS -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-xl font-bold">Recent Orders</h2>
                            <a href="{{ route('orders.my') }}" class="text-sm text-blue-600 hover:underline">
                                Manage orders
                            </a>
                        </div>

                        <div class="space-y-4">
                            @forelse($recentOrders as $order)
                                <a href="{{ route('orders.show', $order) }}"
                                   class="block border rounded-xl p-4 hover:bg-gray-50 transition">

                                    <div class="flex justify-between gap-4">
                                        <div>
                                            <p class="font-bold">
                                                Order #{{ $order->id }}
                                            </p>

                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $order->created_at->format('d M Y H:i') }}
                                            </p>

                                            <p class="text-sm text-gray-500">
                                                Seller:
                                                {{ $order->sellerProfile->store_name ?? 'Seller Store' }}
                                            </p>
                                        </div>

                                        <div class="text-right">
                                            <span class="text-xs px-3 py-1 rounded-full
                                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                                {{ in_array($order->status, ['pending','awaiting_shipment','shipped','delivered']) ? 'bg-blue-100 text-blue-700' : '' }}">
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>

                                            <p class="font-bold mt-3">
                                                R{{ number_format($order->total_amount, 2) }}
                                            </p>
                                        </div>
                                    </div>

                                </a>
                            @empty
                                <p class="text-gray-500">You have not placed any orders yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- RECENT ITEMS -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-xl font-bold mb-5">Recently Purchased Items</h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @forelse($recentItems as $item)
                                <div class="border rounded-xl p-3 hover:shadow transition">

                                    @php
                                        $image = $item->product?->images?->first();
                                    @endphp

                                    <a href="{{ $item->product ? url('/products/' . $item->product->id) : '#' }}">
                                        <img src="{{ $image ? asset('storage/' . $image->image_path) : '/placeholder.png' }}"
                                             class="w-full h-36 object-cover rounded-xl mb-3">
                                    </a>

                                    <p class="font-semibold text-sm">
                                        {{ $item->product_name ?? $item->product->name ?? 'Deleted Product' }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        Qty: {{ $item->quantity }}
                                    </p>

                                    <p class="font-bold mt-2">
                                        R{{ number_format($item->subtotal, 2) }}
                                    </p>
                                </div>
                            @empty
                                <p class="text-gray-500">No purchased items yet.</p>
                            @endforelse
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN -->
                <div class="space-y-6">

                    <!-- QUICK ACTIONS -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-xl font-bold mb-4">Quick Actions</h2>

                        <div class="space-y-3">
                            <a href="{{ route('marketplace.index') }}"
                               class="block text-center bg-black text-white py-3 rounded-3xl hover:bg-gray-800">
                                Browse Marketplace
                            </a>

                            <a href="{{ route('wishlist.index') }}"
                               class="block text-center border py-3 rounded-3xl hover:bg-gray-50">
                                View Wishlist
                            </a>

                            <a href="{{ route('cart.index') }}"
                               class="block text-center border py-3 rounded-3xl hover:bg-gray-50">
                                View Cart
                            </a>

                            <a href="{{ route('support.contact') }}"
                               class="block text-center border py-3 rounded-3xl hover:bg-gray-50">
                                Contact Support
                            </a>
                        </div>
                    </div>

                    <!-- BUYER PROTECTION -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-xl font-bold mb-3">Buyer Protection</h2>

                        <div class="space-y-4 text-sm text-gray-600">
                            <div class="border rounded-xl p-4">
                                <p class="font-semibold text-gray-900">Escrow Protection</p>
                                <p>Your payment is held until the order process is completed.</p>
                            </div>

                            <div class="border rounded-xl p-4">
                                <p class="font-semibold text-gray-900">Dispute Support</p>
                                <p>You can open a dispute if something goes wrong with an order.</p>
                            </div>

                            <div class="border rounded-xl p-4">
                                <p class="font-semibold text-gray-900">Review System</p>
                                <p>Leave reviews after delivery to help other buyers.</p>
                            </div>
                        </div>
                    </div>

                    <!-- REVIEW ACTIVITY -->
                    <div class="bg-white rounded-xl shadow p-6">
                        <h2 class="text-xl font-bold mb-3">Review Activity</h2>

                        <p class="text-gray-500 text-sm">
                            Reviews submitted
                        </p>

                        <p class="text-3xl font-bold mt-2">
                            {{ $reviewsSubmitted }}
                        </p>

                        <a href="{{ route('orders.my') }}"
                           class="inline-block mt-4 text-blue-600 hover:underline text-sm">
                            Check reviewable orders
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>