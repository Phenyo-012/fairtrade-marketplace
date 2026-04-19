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
            <div class="bg-white p-6 rounded-2xl shadow mb-6 mt-5">
                <h3 class="text-lg font-semibold text-black">
                    Welcome {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} 👋
                </h3>
                <p class="text-gray-500 mt-1">
                    Manage your store and track your performance.
                </p>
            </div>

            <!-- SELLER NAVIGATION BUTTONS -->

            <div class="bg-white p-6 rounded-2xl shadow mb-4 mt-6">
                <h3 class="text-lg font-semibold text-black">
                    Quick Actions
                </h3>

                <p class="text-gray-500 mt-1">
                    Use these shortcuts to quickly access important sections of your seller dashboard.
                </p>
                <div class="text-sm text-gray-500 mb-6 mt-6 flex gap-4">
                
                    <!-- EDIT STORE-->
                    <a href="{{ route('seller.store.edit') }}" class="px-4 py-2 bg-white text-black border border-black rounded-3xl hover:bg-blue-300 transition shadow-md">
                        Edit Store
                    </a>
                    <!-- VIEW STORE -->
                    <a href="{{ route('store.show', Auth::user()->sellerProfile->id) }}" class="px-4 py-2 bg-white text-black border border-black rounded-3xl hover:bg-green-400 transition shadow-md">
                        View Store
                    </a>
                    <!-- ORDER MANAGEMENT -->
                    <a href="{{ route('seller.orders.index') }}" class="px-4 py-2 bg-white text-black border border-black rounded-3xl hover:bg-purple-300 transition shadow-md">
                        Order Management
                    </a>
                    <!-- PRODUCT MANAGEMENT -->
                    <a href="{{ route('seller.products.index') }}" class="px-4 py-2  bg-white text-black border border-black rounded-3xl hover:bg-yellow-300 transition shadow-md">
                        Product Management
                    </a>
                    <!-- DISPUTE MANAGEMENT -->
                    <a href="{{ route('seller.disputes.index') }}" class="px-4 py-2  bg-white text-black border border-black rounded-3xl hover:bg-red-400 transition shadow-md">
                        Disputes
                    </a>

                </div>

            </div>
            
           
            <div class="bg-white p-6 rounded-2xl shadow mb-6 mt-6">
                <h3 class="text-lg font-semibold text-black">
                    Performance Badge
                </h3>

                <p class="text-gray-500 mt-1 mb-4">
                    Keep Performing well to collect more Badges!
                </p>

                <div class="flex items-center gap-5">
                    @if($averageRating >= 4.8)    
                        <div class="bg-yellow-300 text-black px-3 py-1 rounded-full text-sm shadow">
                            Top Rated Seller
                        </div>
                    @endif                         
                    @if($onTimeRate >= 95)
                        <div class="bg-blue-300 text-black px-3 py-1 rounded-full text-sm shadow">
                            Fast Shipper
                        </div>
                    @endif
                    @if($totalReviews >= 250)
                        <div class="bg-green-300 text-black px-3 py-1 rounded-full text-sm shadow">
                            Popular Seller
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold mb-2">
                    Shipping Performance
                </h3>

                <p class="text-3xl font-bold text-blue-600">
                    {{ $onTimeRate }}%
                </p>

                <p class="text-sm text-gray-500">
                    On-time shipping rate
                </p>

                <div class="mt-3 text-sm">
                    <p>Total shipped: {{ $totalShipped }}</p>
                    <p class="text-red-500">Late shipments: {{ $lateShipments }}</p>
                </div>
            </div>
                

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                    <p class="text-sm text-black">
                        Total Revenue
                    </p>
                    <p class="text-3xl font-bold mt-2">
                        R{{ number_format($totalRevenue, 2) }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                    <p class="text-sm text-black">
                        Total Orders
                    </p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $totalOrders }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                    <p class="text-sm text-black">
                        Products Listed
                    </p>
                    <p class="text-3xl font-bold mt-2">
                        {{ $totalProducts }}
                    </p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition ">
                    <p class="text-sm text-black mb-1">
                        Average Rating
                    </p>
                    <div class="flex items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            @if($averageRating >= $i)
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                    <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                        0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                        <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                    </path>
                                </svg>
                            @elseif($averageRating > $i - 1)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                        <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                        0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                        <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="0"/>
                                    </path>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                    <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                        0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                        <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="0"/>
                                    </path>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <div class="mt-1 flex items-center gap-2">
                        <span class="text-lg font-bold">
                            {{ number_format($averageRating, 1) }}
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
                    <h3 class="font-semibold text-black mb-4">
                        Revenue Over Time
                    </h3>

                    @if($revenueData->isEmpty())
                        <p class="text-gray-500">No revenue data yet.</p>
                    @else
                        <canvas id="revenueChart"></canvas>
                    @endif
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <h3 class="font-semibold text-black mb-4">
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
                    <h3 class="font-semibold text-black mb-4">
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
                <h3 class="font-semibold text-black mb-4">
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
                <h3 class="font-semibold text-black mb-4">
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
                                    @else bg-gray-200 text-gray-600
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
                <h3 class="font-semibold text-black mb-4">
                    Recent Reviews
                </h3>

                <div class="space-y-4">
                    @forelse($recentReviews as $review)
                        <div class="border rounded-xl p-4">
                            <div class="flex items-center text-black font-semibold gap-1">
                                <span>{{ $review->rating }}</span>

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="18"
                                    height="18"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        fill-opacity="0"
                                        stroke="currentColor"
                                        stroke-dasharray="66"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 3l2.35 5.76l6.21 0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                        <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                    </path>
                                </svg>
                            </div>
                            <p class="text-gray-600 mt-1">
                                {{ $review->comment }}
                            </p>
                        </div>
                    @empty
                        <p class="text-gray-500">No reviews yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Rating Distribution -->
            <div class="bg-white p-6 rounded-2xl shadow mb-6 mt-6">
                <h3 class="font-semibold text-black mb-4">
                    Rating Distribution
                </h3>

                @for($i = 5; $i >= 1; $i--)
                    <div class="flex items-center gap-2 text-sm mb-1">

                        <!-- rating + star -->
                        <div class="flex items-center gap-1 w-10 mb-1">
                            <span>{{ $i }}</span>

                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                class="text-black">
                                <path fill="currentColor"
                                    fill-opacity="0"
                                    stroke="currentColor"
                                    stroke-dasharray="66"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 3l2.35 5.76l6.21 0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                    <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                </path>
                            </svg>
                        </div>

                        <!-- count -->
                        <span>Reviews: {{ $ratingDistribution[$i] ?? 0 }}</span>

                    </div>
                @endfor
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