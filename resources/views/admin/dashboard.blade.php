<x-app-layout>

    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-4">

            <!-- HEADER -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold">Admin Control Centre</h1>
                <p class="text-gray-500">Platform overview and operational insights</p>
            </div>

            <!-- ACTION CARDS -->
            <div class="grid md:grid-cols-4 gap-6 mb-10">
                <a href="{{ route('admin.products') }}"
                class="bg-white border border-gray-300 p-5 rounded-xl shadow-md hover:shadow-md hover:bg-yellow-100">
                    <p class="text-sm text-yellow-700">Pending Products Approvals</p>
                    <h2 class="text-2xl font-bold">{{ $pendingProducts }}</h2>
                </a>

                <a href="{{ route('admin.sellers.index') }}"
                class="bg-white border border-gray-300 p-5 rounded-xl shadow-md hover:shadow-md hover:bg-blue-100">
                    <p class="text-sm text-blue-700">Seller Applications Open</p>
                    <h2 class="text-2xl font-bold">{{ $pendingSellers }}</h2>
                </a>

                <a href="{{ route('admin.disputes') }}"
                class="bg-white border border-gray-300 p-5 rounded-xl shadow-md hover:shadow-md hover:bg-red-100">
                    <p class="text-sm text-red-700">Open Disputes</p>
                    <h2 class="text-2xl font-bold">{{ $openDisputes }}</h2>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                class="bg-white border border-gray-300 p-5 rounded-xl shadow-md hover:shadow-md hover:bg-green-100">
                    <p class="text-sm text-green-700">Seller Orders</p>
                    <h2 class="text-2xl font-bold">{{ $totalOrders }}</h2>
                </a>
            </div>

            <!-- KPI ROW -->
            <div class="grid md:grid-cols-4 gap-6 mb-10">

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Users</p>
                    <h2 class="text-2xl font-bold">{{ $totalUsers }}</h2>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Sellers</p>
                    <h2 class="text-2xl font-bold">{{ $totalSellers }}</h2>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Products</p>
                    <h2 class="text-2xl font-bold">{{ $totalProducts }}</h2>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Reviews</p>
                    <h2 class="text-2xl font-bold">{{ $totalReviews }}</h2>
                </div>

            </div>

            <!-- REVENUE SECTION -->
            <div class="grid md:grid-cols-2 gap-6 mb-10">

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Platform Revenue (5%)</p>
                    <h2 class="text-3xl font-bold text-green-600">
                        R{{ number_format($platformRevenue, 2) }}
                    </h2>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Seller Revenue</p>
                    <h2 class="text-3xl font-bold">
                        R{{ number_format($totalRevenue, 2) }}
                    </h2>
                </div>

            </div>

            <!-- ANALYTICS -->
            <div class="bg-white p-6 rounded-xl shadow mb-10">
                
                <h3 class="font-bold mb-4">Revenue (Last 180 Days)</h3>
                <div class="relative w-full h-[350px] sm:h-[400px] lg:h-[450px]">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- OPERATIONAL METRICS -->
            <div class="grid md:grid-cols-3 gap-6 mb-10">

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Late Orders</p>
                    <h2 class="text-2xl font-bold text-red-600">
                        {{ number_format($latePercentage, 1) }}%
                    </h2>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Avg Delivery Time</p>
                    <h2 class="text-2xl font-bold">
                        {{ number_format($avgDeliveryTime ?? 0, 1) }} hrs
                    </h2>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <p class="text-gray-500">Disputes</p>
                    <h2 class="text-2xl font-bold text-red-500">
                        {{ $totalDisputes }}
                    </h2>
                </div>

            </div>

            <!-- FRAUD MONITORING -->
            <div class="bg-red-100 p-6 rounded-xl shadow">

                <h3 class="font-bold mb-4 text-red-700">Fraud Monitoring</h3>

                <div class="grid md:grid-cols-2 gap-4">

                    <div>
                        <h4 class="font-semibold mb-2">Suspicious Sellers</h4>
                        @foreach($badSellers as $seller)
                            <p class="text-red-600">
                                ⚠ {{ $seller->store_name }} ({{ $seller->disputes }} disputes)
                            </p>
                        @endforeach
                    </div>

                    <div>
                        <h4 class="font-semibold mb-2">Suspicious Buyers</h4>
                        @foreach($badBuyers as $buyer)
                            <p class="text-red-600">
                                ⚠ {{ $buyer->name }} ({{ $buyer->disputes }} disputes)
                            </p>
                        @endforeach
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- CHART -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($dailyRevenue->pluck('date'));
        const data = @json($dailyRevenue->pluck('total'));
        const platformRevenue = @json($dailyRevenue->pluck('total')->map(fn ($total) => $total * 0.05));
       
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Seller Revenue',
                        data,
                        tension: 0.4,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    },
                    {
                        label: 'Platform Revenue (5%)',
                        data: platformRevenue,
                        tension: 0.4,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    }
                ]
            },
            options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
        });



    </script>

</x-app-layout>