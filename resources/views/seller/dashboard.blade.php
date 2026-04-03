<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            Seller Dashboard
        </h2>
    </x-slot>

    <!-- Grey background wrapper -->
    <div class="bg-gray-100 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 space-y-8">

            <!-- Welcome -->
            <div class="bg-white p-6 rounded-2xl shadow mb-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-700">
                    Welcome {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} 👋
                </h3>
                <p class="text-gray-500 mt-1">
                    Manage your store and track your performance.
                </p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Total Revenue</p>
                    <p class="text-3xl font-bold mt-2">
                        R{{ number_format($totalRevenue, 2) }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $totalOrders }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Products Listed</p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $totalProducts }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition mb-6">
                    <p class="text-sm text-gray-500">Average Rating</p>
                    <div class="flex items-center gap-2">
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= floor($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                            @endfor
                        </div>
                        <span class="text-lg font-bold">
                            {{ $averageRating }}
                        </span>
                        <span class="text-sm text-gray-500">
                            ({{ $totalReviews }} reviews)
                        </span>
                    </div>
                </div>

            </div>

            <!-- Charts -->
            <div class="grid md:grid-cols-2 gap-6 mb-6">

                <div class="bg-white p-6 rounded-2xl shadow">
                    <h3 class="font-semibold text-gray-700 mb-4">
                        Revenue Over Time
                    </h3>

                    @if($revenueData->isEmpty())
                        <p class="text-gray-500">No revenue data yet.</p>
                    @else
                        <canvas id="revenueChart"></canvas>
                    @endif
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <h3 class="font-semibold text-gray-700 mb-4">
                        Orders Over Time
                    </h3>

                    @if($orderData->isEmpty())
                        <p class="text-gray-500">No order data yet.</p>
                    @else
                        <canvas id="ordersChart"></canvas>
                    @endif
                </div>

            </div>

            <!-- Earnings + Stock -->
            <div class="grid md:grid-cols-2 gap-6 mb-6">

                <div class="bg-white p-6 rounded-2xl shadow">
                    <h3 class="font-semibold text-gray-700 mb-4">
                        Earnings Breakdown
                    </h3>

                    <p class="text-gray-600">
                        Total Revenue:
                        <span class="font-semibold text-black">
                            R{{ number_format($totalRevenue,2) }}
                        </span>
                    </p>

                    <p class="text-gray-600 mt-2">
                        Platform Fee (5%):
                        <span class="font-semibold text-red-500">
                            R{{ number_format($platformEarnings,2) }}
                        </span>
                    </p>

                    <p class="text-gray-600 mt-2">
                        Your Earnings:
                        <span class="font-semibold text-green-600">
                            R{{ number_format($sellerEarnings,2) }}
                        </span>
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <h3 class="font-semibold text-red-600 mb-4">
                        Low Stock Alerts
                    </h3>

                    @forelse($lowStockProducts as $product)
                        <p class="text-sm text-gray-700">
                            {{ $product->name }}
                            <span class="text-red-500 font-semibold">
                                ({{ $product->stock_quantity }} left)
                            </span>
                        </p>
                    @empty
                        <p class="text-gray-500">No low stock issues.</p>
                    @endforelse
                </div>

            </div>

            <!-- Top Products -->
            <div class="bg-white p-6 rounded-2xl shadow mb-6">
                <h3 class="font-semibold text-gray-700 mb-4">
                    Top Selling Products
                </h3>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="pb-2">Product</th>
                            <th class="pb-2">Sales</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($topProducts as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3">
                                {{ $item->product->name ?? 'Deleted Product' }}
                            </td>
                            <td>
                                <span class="font-semibold">
                                    {{ $item->total_sales }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="py-3 text-center text-gray-500">
                                No sales yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white p-6 rounded-2xl shadow mb-6">
                <h3 class="font-semibold text-gray-700 mb-4">
                    Recent Orders
                </h3>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="pb-2">Order</th>
                            <th class="pb-2">Amount</th>
                            <th class="pb-2">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3">#{{ $order->id }}</td>
                            <td>R{{ number_format($order->total_amount,2) }}</td>
                            <td>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($order->status == 'completed') bg-green-100 text-green-700
                                    @elseif($order->status == 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($order->status == 'shipped') bg-blue-100 text-blue-700
                                    @else bg-gray-100 text-gray-600
                                    @endif
                                ">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Reviews -->
            <div class="bg-white p-6 rounded-2xl shadow mb-6">
                <h3 class="font-semibold text-gray-700 mb-4">
                    Recent Reviews
                </h3>

                <div class="space-y-4">
                    @forelse($recentReviews as $review)
                        <div class="border rounded-xl p-4">
                            <p class="text-yellow-500 font-semibold">
                                {{ $review->rating }} ⭐
                            </p>
                            <p class="text-gray-600 mt-1">
                                {{ $review->comment }}
                            </p>
                        </div>
                    @empty
                        <p class="text-gray-500">No reviews yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const revenueLabels = @json($revenueData->pluck('date'));
        const revenueValues = @json($revenueData->pluck('total'));

        const orderLabels = @json($orderData->pluck('date'));
        const orderValues = @json($orderData->pluck('total'));

        if (revenueLabels.length) {
            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: revenueLabels,
                    datasets: [{
                        label: 'Revenue',
                        data: revenueValues
                    }]
                }
            });
        }

        if (orderLabels.length) {
            new Chart(document.getElementById('ordersChart'), {
                type: 'bar',
                data: {
                    labels: orderLabels,
                    datasets: [{
                        label: 'Orders',
                        data: orderValues
                    }]
                }
            });
        }
    </script>

</x-app-layout>