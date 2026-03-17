<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Seller Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                Welcome {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}.
                Manage your store and products here.
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="bg-white p-6 rounded shadow">
                    <p class="text-gray-500">Total Revenue</p>
                    <p class="text-2xl font-bold">
                        ${{ number_format($totalRevenue, 2) }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <p class="text-gray-500">Total Orders</p>
                    <p class="text-2xl font-bold">
                        {{ $totalOrders }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <p class="text-gray-500">Products Listed</p>
                    <p class="text-2xl font-bold">
                        {{ $totalProducts }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <p class="text-gray-500">Average Rating</p>
                    <p class="text-2xl font-bold">
                        {{ number_format($averageRating,1) }} ⭐
                    </p>
                </div>

            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-semibold mb-4">Revenue Over Time</h3>

                    @if($revenueData->isEmpty())
                        <p class="text-gray-500">No revenue data yet.</p>
                    @else
                        <canvas id="revenueChart"></canvas>
                    @endif
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-semibold mb-4">Orders Over Time</h3>

                    @if($orderData->isEmpty())
                        <p class="text-gray-500">No order data yet.</p>
                    @else
                        <canvas id="ordersChart"></canvas>
                    @endif
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Earnings Breakdown -->
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-semibold mb-4">Earnings Breakdown</h3>

                    <p>Total Revenue: <strong>${{ number_format($totalRevenue,2) }}</strong></p>
                    <p>Platform Fee (5%): <strong class="text-red-500">
                        ${{ number_format($platformEarnings,2) }}
                    </strong></p>
                    <p>Your Earnings: <strong class="text-green-600">
                        ${{ number_format($sellerEarnings,2) }}
                    </strong></p>
                </div>

                <!-- Low Stock -->
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-semibold mb-4 text-red-600">Low Stock Alerts</h3>

                    @forelse($lowStockProducts as $product)
                        <p class="text-sm">
                            {{ $product->name }} ({{ $product->stock_quantity }} left)
                        </p>
                    @empty
                        <p class="text-gray-500">No low stock issues.</p>
                    @endforelse
                </div>

            </div>

            <div class="bg-white p-6 rounded shadow">

                <h3 class="font-semibold mb-4">Top Selling Products</h3>

                <table class="w-full border">
                    <tr class="bg-gray-200">
                        <th class="p-2">Product</th>
                        <th class="p-2">Sales</th>
                    </tr>

                    @forelse($topProducts as $item)
                    <tr class="border-t">
                        <td class="p-2">
                            {{ $item->product->name ?? 'Deleted Product' }}
                        </td>
                        <td class="p-2">
                            {{ $item->total_sales }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="p-2 text-center text-gray-500">
                            No sales yet.
                        </td>
                    </tr>
                    @endforelse

                </table>

            </div>

            <!-- Recent Orders -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="font-semibold mb-4">Recent Orders</h3>

                <table class="w-full border">
                    <tr class="bg-gray-200">
                        <th class="p-2">Order</th>
                        <th class="p-2">Amount</th>
                        <th class="p-2">Status</th>
                    </tr>

                    @foreach($recentOrders as $order)
                    <tr class="border-t">
                        <td class="p-2">#{{ $order->id }}</td>
                        <td class="p-2">${{ number_format($order->total_amount, 2) }}</td>
                        <td class="p-2">{{ $order->status }}</td>
                    </tr>
                    @endforeach

                </table>
            </div>

            <!-- Reviews -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="font-semibold mb-4">Recent Reviews</h3>

                @forelse($recentReviews as $review)
                    <div class="border p-4 mb-2 rounded">
                        <strong>{{ $review->rating }} ⭐</strong>
                        <p>{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">No reviews yet.</p>
                @endforelse

            </div>

        </div>
    </div>

    <!-- Scripts INSIDE layout -->
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