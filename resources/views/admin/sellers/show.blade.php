<x-app-layout>

    <div class="max-w-6xl mx-auto py-10">

        <h1 class="text-2xl font-bold mb-6">{{ $seller->store_name }}</h1>

        <!-- STATS -->
        <div class="grid md:grid-cols-4 gap-4 mb-8">

            <div class="bg-white p-4 rounded shadow">
                <p>Earnings</p>
                <h2 class="font-bold">R{{ number_format($earnings, 2) }}</h2>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <p>Products</p>
                <h2 class="font-bold">{{ $products->count() }}</h2>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <p>Avg Rating</p>
                <h2 class="font-bold">{{ number_format($reviews->avg_rating ?? 0, 1) }}</h2>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <p>Reviews</p>
                <h2 class="font-bold">{{ $reviews->total_reviews ?? 0 }}</h2>
            </div>

        </div>

        <!-- RECENT ORDERS -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-bold mb-4">Recent Orders</h3>

            @foreach($orders as $item)
                <div class="flex justify-between border-b py-2">
                    <span>{{ $item->product->name }}</span>
                    <span>R{{ number_format($item->subtotal, 2) }}</span>
                </div>
            @endforeach
        </div>

    </div>

</x-app-layout>