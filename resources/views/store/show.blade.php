<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">
<div class="max-w-7xl mx-auto px-4">

    <!-- STORE HEADER -->
    <div class="bg-white p-6 rounded-2xl shadow mb-6 flex items-center gap-6">

        <!-- LOGO -->
        <div>
            @if($seller->logo)
                <img src="{{ asset('storage/'.$seller->logo) }}"
                     class="w-24 h-24 rounded-full object-cover">
            @else
                <div class="w-24 h-24 bg-gray-200 rounded-full"></div>
            @endif
        </div>

        <!-- INFO -->
        <div>
            <h2 class="text-2xl font-bold">
                {{ $seller->store_name ?? 'Store' }}
            </h2>

            <!-- BADGES -->
            <div class="mt-3 flex gap-3">

                @if($averageRating >= 4.8)
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                         Top Rated
                    </span>
                @endif

                @if($onTimeRate >= 95)
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                         Fast Shipper
                    </span>
                @endif

                @if($totalReviews >= 250)
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                         Popular
                    </span>
                @endif

                @if($seller->is_verified)
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                         Verified
                    </span>
                @endif

            </div>
        </div>

    </div>

    <!-- STATS -->
    <div class="grid grid-cols-3 gap-4 mb-6">

        <!-- AVERAGE RATING SIMILAR TO ON DASHBOARD -->
        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500 text-sm">Average Rating</p>
            <p class="text-xl font-bold">{{ number_format($averageRating, 1) }} ⭐</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500 text-sm">Reviews</p>
            <p class="text-xl font-bold">{{ $totalReviews }}</p>
        </div>

        <div class="bg-white p-4 rounded-xl shadow text-center">
            <p class="text-gray-500 text-sm">On-Time</p>
            <p class="text-xl font-bold">{{ $onTimeRate }}%</p>
        </div>

    </div>

    <!-- PRODUCTS -->
    <div class="bg-white p-6 rounded-2xl shadow mb-6">

        <h3 class="text-lg font-semibold mb-4">Products</h3>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            @foreach($products as $product)
                @php $image = $product->images->first(); @endphp

                <a href="/products/{{ $product->id }}"
                   class="border rounded-lg p-3 hover:shadow-md transition">

                    @if($image)
                        <img src="{{ asset('storage/'.$image->image_path) }}"
                             class="w-full h-auto object-cover rounded mb-2">
                    @endif

                    <p class="font-semibold text-sm">
                        {{ $product->name }}
                    </p>

                    <p class="text-green-600 font-bold">
                        R{{ number_format($product->price,2) }}
                    </p>

                </a>
            @endforeach

        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>

    </div>

    <!-- REVIEWS -->
    <div class="bg-white p-6 rounded-2xl shadow">

        <h3 class="text-lg font-semibold mb-4">Recent Reviews</h3>

        <!-- REVIEW ITEM LIMITED TO 5 RECENT REVIEWS -->
        @foreach($displayReviews as $review)
            <div class="border-b py-3">
                <p class="text-black-500">Rating: {{ $review->rating }} ⭐ </p>
                <p class="text-sm text-gray-600">{{ $review->comment }}</p>
            </div>

            <!-- LIMIT TO 5 REVIEWS -->
            @if($loop->iteration >= 5)
                @break
            @endif

        @endforeach

        <!-- VIEW ALL REVIEWS LINK -->
        <div class="mt-4 text-left">
            <a href="{{ route('store.reviews', $seller) }}"
               class="text-blue-600 hover:underline text-sm">
                View All Reviews
            </a>    
        </div>    
        
    </div>

    <!-- SELLER ABOUT SECTION -->
    <div class="bg-white p-6 rounded-2xl shadow mt-6">

        <h3 class="text-lg font-semibold mb-4">About the Seller</h3>

        <p class="text-gray-600">
            {{ $seller->about ?? 'No description yet.' }}
        </p>

    </div>

</div>
</div>

</x-app-layout>