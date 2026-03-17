<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Seller Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    Welcome {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}.
                    Manage your store and products here.
                </div>
            </div>

            <!-- Analytics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500">Total Revenue</p>
                    <p class="text-2xl font-bold">
                        ${{ $totalRevenue }}
                    </p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500">Total Orders</p>
                    <p class="text-2xl font-bold">
                        {{ $totalOrders }}
                    </p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500">Products Listed</p>
                    <p class="text-2xl font-bold">
                        {{ $totalProducts }}
                    </p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-500">Average Rating</p>
                    <p class="text-2xl font-bold">
                        {{ number_format($averageRating,1) }} ⭐
                    </p>
                </div>

            </div>

            <!-- Recent Orders -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-4">
                        Recent Orders
                    </h3>

                    <table class="w-full border">

                        <tr class="bg-gray-200">
                            <th class="p-2">Order</th>
                            <th class="p-2">Amount</th>
                            <th class="p-2">Status</th>
                        </tr>

                        @foreach($recentOrders as $order)

                        <tr class="border-t">
                            <td class="p-2">#{{ $order->id }}</td>
                            <td class="p-2">${{ $order->total_amount }}</td>
                            <td class="p-2">{{ $order->status }}</td>
                        </tr>

                        @endforeach

                    </table>

                </div>
            </div>

            <!-- Recent Reviews -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-4">
                        Recent Reviews
                    </h3>

                    @forelse($recentReviews as $review)

                        <div class="border p-4 mb-2 rounded">
                            <strong>{{ $review->rating }} ⭐</strong>
                            <p>{{ $review->comment }}</p>
                        </div>

                    @empty

                        <p class="text-gray-500">
                            No reviews yet.
                        </p>

                    @endforelse

                </div>
            </div>

        </div>
    </div>
</x-app-layout>