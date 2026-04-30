<x-app-layout>

    <div class="max-w-6xl mx-auto py-3 px-4">

        <a href="{{ route('admin.sellers.index') }}" class="mt-6 px-4 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                </path>
            </svg>
        </a>

        <h1 class="text-2xl font-bold mb-6">{{ $seller->store_name }}</h1>

        <!-- STATS -->
        <div class="grid md:grid-cols-4 gap-4 mb-8">

            <div class="bg-white p-4 rounded-xl shadow">
                <p>Earnings</p>
                <h2 class="font-bold">R{{ number_format($earnings, 2) }}</h2>
            </div>

            <div class="bg-white p-4 rounded-xl shadow">
                <p>Products</p>
                <h2 class="font-bold">{{ $products->count() }}</h2>
            </div>

            <div class="bg-white p-4 rounded-xl shadow">
                <p>Avg Rating</p>
                <h2 class="font-bold">{{ number_format($reviews->avg_rating ?? 0, 1) }}</h2>
            </div>

            <div class="bg-white p-4 rounded-xl shadow">
                <p>Reviews</p>
                <h2 class="font-bold">{{ $reviews->total_reviews ?? 0 }}</h2>
            </div>

        </div>

        <!-- RECENT ORDERS -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-bold mb-4">Recent Products Ordered</h3>

            @foreach($orders as $item)
                <div class="flex justify-between border-b py-2">
                    <span>{{ $item->product->name }}</span>
                    <span>R{{ number_format($item->subtotal, 2) }}</span>
                </div>
            @endforeach
        </div>

        <!-- PAGINATION -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>

    </div>

</x-app-layout>