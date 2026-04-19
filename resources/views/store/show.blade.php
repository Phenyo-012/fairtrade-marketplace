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

                <a href="{{ route('chat.start', $seller->user_id) }}"
                    class="bg-white text-black border border-gray-400 px-4 py-2 rounded-3xl 
                    justify-center mt-4 inline-flex items-center gap-2 hover:bg-blue-200 transition shadow-md">
                    Message Seller
                </a>
            </div>

        </div>

        <!-- STATS -->
        <div class="grid grid-cols-3 gap-4 mb-6">

            <!-- AVERAGE RATING SIMILAR TO ON DASHBOARD -->
            <div class="bg-white p-4 rounded-xl shadow text-center">
                <p class="text-gray-500 text-sm">Average Rating</p>
                <p class="text-xl font-bold">{{ number_format($averageRating, 1) }}/5</p>
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
        <div class="mt-6 mb-6 font-bold text-2xl">
            <h3>
                Seller Products
            </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-11">

            @foreach($products as $product)

                <a href="/products/{{ $product->id }}" 
                    class="relative group block bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden group hover:scale-105">

                    <div class="p-2">

                        <!-- IMAGE -->
                        @if($product->images->count())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-80 object-cover rounded-xl mb-3 transition-transform">
                        @else
                            <div class="w-full h-80 object-cover flex items-center justify-center rounded-xl mb-3 transition-transform">
                                No Image
                            </div>
                        @endif

                        <!-- NAME -->
                        <h3 class="font-semibold text-lg text-gray-800 group-hover:text-blue-600 transition">
                                {{ $product->name }}
                        </h3>

                        <!-- RATING -->
                        @php
                            $rating = round($product->reviews->avg('rating'), 1);
                        @endphp

                        <div class="flex items-center gap-1 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($rating >= $i)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                        <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                            0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                            <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                        </path>
                                    </svg>
                                @elseif($rating > $i - 1)
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
                            <span class="text-xs text-gray-500">
                                ({{ number_format($rating, 1) }})
                            </span>
                        </div>

                        <!-- CONDITION -->
                        <span class="text-xs px-2 py-1 rounded-xl inline-block mt-1
                                {{ $product->condition == 'new' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst(str_replace('_', ' ', $product->condition)) }}
                        </span>

                        <!-- PRICE -->
                        @if($product->is_on_sale)
                            <div class="flex items-center gap-2 mb-3 mt-3">
                                <span class="text-blue-600 font-bold text-lg">
                                    R{{ number_format($product->discounted_price, 2) }} 
                                </span>

                                <span class="text-gray-400 line-through text-sm">
                                    R{{ number_format($product->price, 2) }} 
                                </span>
                                <p class="text-gray-400 text-sm">
                                    ({{ $product->discount_percentage }}% OFF)
                                </p>
                            </div>
                        @else
                            <p class="font-bold text-gray-900 mt-3">
                                R{{ number_format($product->price, 2) }}
                            </p>
                        @endif

                        @if($product->free_shipping)
                            <span class="text-xs bg-green-100 text-black px-2 py-1 rounded-xl mt-1 inline-block">
                                FREE Shipping
                            </span>
                        @endif

                        @auth
                        <form method="POST" action="{{ route('wishlist.toggle', $product) }}"
                                class="absolute top-5 right-6 z-10 opacity-0 group-hover:opacity-100 transition duration-200">
                            @csrf

                            <button type="submit"
                                class="bg-white/90 backdrop-blur p-2 rounded-full shadow hover:scale-110 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="#ff0505" stroke-dasharray="30" stroke-linecap="round" 
                                    stroke-linejoin="round" stroke-width="2" d="M12 8c0 0 0 0 -0.76 -1c-0.88 -1.16 
                                    -2.18 -2 -3.74 -2c-2.49 0 -4.5 2.01 -4.5 4.5c0 0.93 0.28 1.79 0.76 2.5c0.81 1.21 
                                    8.24 9 8.24 9M12 8c0 0 0 0 0.76 -1c0.88 -1.16 2.18 -2 3.74 -2c2.49 0 4.5 2.01 4.5 
                                    4.5c0 0.93 -0.28 1.79 -0.76 2.5c-0.81 1.21 -8.24 9 -8.24 9">
                                    </path>
                                </svg>
                            </button>
                        </form>
                        @endauth
                    </div>
                </a>
            @endforeach
        </div>

        <!-- REVIEWS -->
        <div class="bg-white p-6 rounded-2xl shadow">

            <h3 class="text-lg font-semibold mb-4">
                Recent Reviews
            </h3>

            <!-- REVIEW ITEM LIMITED TO 5 RECENT REVIEWS -->
            @foreach($displayReviews as $review)
                <div class="border rounded-xl p-4 mb-4">
                                <div class="flex items-center text-black font-semibold gap-1">
                                    <span>{{ $review->rating }}</span>

                                    @switch($review->rating)
                                    @case (5)
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                                0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                                <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                            </path>
                                            </svg>
                                        @endfor
                                        @break
                                    @case (4)
                                        @for($i = 1; $i <= 4; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                                0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                                <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                            </path>
                                            </svg>
                                        @endfor
                                        @break
                                    @case (3)
                                        @for($i = 1; $i <= 3; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                                0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                                <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                            </path>
                                            </svg>
                                        @endfor
                                        @break
                                    @case (2)
                                        @for($i = 1; $i <= 2; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                                0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                                <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                            </path>
                                            </svg>
                                        @endfor
                                        @break
                                    @case (1)
                                        @for($i = 1; $i <= 1; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                                0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                                <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                            </path>
                                            </svg>
                                        @endfor
                                        @break
                                    @default
                                            <p>
                                                error
                                            </p>
                                @endswitch
                                </div>
                                <p class="text-gray-600 mt-1">
                                    {{ $review->comment }}
                                </p>
                            </div>

                <!-- LIMIT TO 5 REVIEWS -->
                @if($loop->iteration >= 5)
                    @break
                @endif

            @endforeach

            <!-- VIEW ALL REVIEWS LINK -->
            <div class="mt-4 text-left">
                <a href="{{ route('store.reviews', $seller) }}"
                    class="bg-white text-black border border-gray-400 px-4 py-2 rounded-3xl 
                    justify-center mt-4 inline-flex items-center gap-2 hover:bg-blue-200 transition shadow-md">
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