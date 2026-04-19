@php
    $rating = $sellerRating ?? 0;
@endphp
<x-app-layout>

    <div class="bg-gray-100 min-h-screen py-10">

        <div class="max-w-6xl mx-auto px-4">

            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">

                <!-- LEFT: IMAGE SECTION -->
                <div class="md:col-span-3">

                    <!-- MAIN IMAGE CONTAINER -->
                    <div class="relative bg-white rounded-2xl shadow overflow-hidden">

                        <div class="w-full h-auto overflow-hidden">
                            @if($product->images->isEmpty())
                                <img src="/placeholder.png"
                                    class="w-full h-full object-cover"
                                    alt="no image">
                            @else
                                <img id="mainImage"
                                    src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                    class="w-full h-full object-cover transition duration-1000 cursor-zoom-in"
                                    onclick="openLightbox(currentIndex)">
                            @endif
                        </div>

                        <!-- LEFT -->
                        <button onclick="prevImage()"
                            class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/90 border border-gray-300 hover:bg-white shadow rounded-full px-3 py-2">
                            ←
                        </button>

                        <!-- RIGHT -->
                        <button onclick="nextImage()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/90 border border-gray-300 hover:bg-white shadow rounded-full px-3 py-2">
                            →
                        </button>

                    </div>

                    <!-- THUMBNAILS -->
                    <div class="flex gap-3 mt-4 overflow-x-auto">
                        @foreach($product->images as $index => $image)
                            <img 
                                src="{{ asset('storage/' . $image->image_path) }}"
                                class="w-20 h-20 object-cover rounded-lg cursor-pointer border hover:border-gray-400 transition"
                                onclick="changeImage({{ $index }})">
                        @endforeach
                    </div>

                </div>

                <!-- RIGHT: PRODUCT DETAILS -->
                <div class="md:col-span-2 top-24 self-start bg-white p-5 rounded-xl shadow space-y-4">

                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ $product->name }}
                    </h2>

                    <span class="text-xs px-2 py-1 rounded-xl 
                    {{ $product->condition == 'new' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst(str_replace('_', ' ', $product->condition)) }}
                </span>
                
                    @if($product->is_on_sale)
                        <div class="flex items-center gap-3">
                            <span class="text-blue-600 font-bold text-3xl">
                                R{{ number_format($product->discounted_price, 2) }}
                            </span>

                            <span class="text-gray-400 line-through text-lg">
                                R{{ number_format($product->price, 2) }}
                            </span>
                        </div>

                        <p class="text-sm text-blue-500">
                            {{ $product->discount_percentage }}% OFF
                        </p>
                    @else
                        <p class="text-3xl font-bold">
                            R{{ number_format($product->price, 2) }}
                        </p>
                    @endif

                    @if($product->free_shipping)
                        <p class="text-green-600 font-medium text-mb">
                            Free Shipping Available
                        </p>
                    @endif

                    <p class="text-sm text-gray-500">
                        Stock: {{ $product->stock_quantity }}
                    </p>

                    <form method="POST" action="{{ route('cart.add', $product) }}" >
                        @csrf

                        <div class="flex items-center gap-3">
                            <button type="button" onclick="decreaseQty()" class="px-3 py-1 bg-white border border-gray-300 rounded-3xl hover:bg-gray-300 transition shadow-sm">
                                -
                            </button>
                            <input id="qty" type="number" name="quantity" value="1"
                                class="border border-gray-300 rounded-xl w-16 text-center focus:ring focus:ring-blue-300 focus:outline-none">
                            <button type="button" onclick="increaseQty()" class="px-3 py-1 bg-white border border-gray-300 rounded-3xl hover:bg-gray-300 transition shadow-sm">
                                +
                            </button>
                        </div>
                        
                        <button class="font-semibold w-full bg-blue-300 hover:bg-gray-300 text-black py-2 border border-gray-300 rounded-3xl mt-6 shadow-md">
                            Add to Cart
                        </button>
                    </form>

                    <!-- ADD TO WISHLIST -->
                    <form method="POST" action="{{ route('wishlist.toggle', $product) }}"class="space-y-3">
                        @csrf

                        <button class="w-full font-semibold block bg-gray-100 hover:bg-gray-500 text-black py-2 border border-gray-300 rounded-3xl mt-6 mb-6 text-center shadow-md">
                            Add to Wishlist
                        </button>
                    </form>
                    
                </div>

            </div>

           <div class="mt-16">
                <div class="bg-white p-6 rounded-2xl shadow">

                    <h3 class="text-lg font-semibold mb-4 text-gray-800">
                        Product Description
                    </h3>

                    <!-- SCROLLABLE DESCRIPTION BOX -->
                    <div id="descriptionBox"
                        class="description-scroll max-h-[300px] overflow-y-auto pr-2">

                        <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed space-y-3">

                            {!! nl2br(e($product->description)) !!}

                        </div>

                    </div>

                </div>
            </div>

            <!-- REVIEWS SECTION -->
            <div class="mt-16">

                <!-- RATING SUMMARY -->
                <div class="bg-white p-6 rounded-xl shadow mb-8">

                    <h3 class="text-lg font-bold mb-4">Rating Breakdown</h3>

                    @for($i = 5; $i >= 1; $i--)
                        <div class="flex items-center gap-3 mb-2">

                            <p>
                                {{ $i }}
                            </p>
                            <span class="w-12 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                    0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                    <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                </path>
                            </svg>
                            </span>

                            <div class="flex-1 bg-gray-200 h-3 rounded-xl">
                                <div class="bg-yellow-400 h-3 rounded-xl"
                                    style="width: {{ $ratingPercentages[$i] ?? 0 }}%">
                                </div>
                            </div>

                            <span class="text-sm text-gray-500 w-10 text-right">
                                {{ $ratingPercentages[$i] ?? 0 }}%
                            </span>

                        </div>
                    @endfor

                    <p class="text-sm text-gray-500 mt-3">
                        {{ $totalReviews }} total reviews
                    </p>

                </div>

                <form method="GET" class="mb-6 flex gap-2">

                    <select name="rating" class="border w-32 rounded-3xl p-2 text-sm">
                        <option value="">All Ratings</option>
                        <option value="5" {{ request('rating') == 5 ? 'selected' : '' }}>5 Stars</option>
                        <option value="4" {{ request('rating') == 4 ? 'selected' : '' }}>4 Stars & up</option>
                        <option value="3" {{ request('rating') == 3 ? 'selected' : '' }}>3 Stars & up</option>
                        <option value="2" {{ request('rating') == 2 ? 'selected' : '' }}>2 Stars & up</option>
                        <option value="1" {{ request('rating') == 1 ? 'selected' : '' }}>1 Star & up</option>
                    </select>

                    <button class="bg-gray-800 text-white px-3 py-2 rounded-3xl text-sm">
                        Filter
                    </button>

                </form>

                <form method="GET" class="mb-6 flex gap-2">

                    <select name="sort" class="border w-32 rounded-3xl p-2 text-sm">
                        <option value="">Sort Reviews</option>
                        <option value="helpful" {{ request('sort') == 'helpful' ? 'selected' : '' }}>Most Helpful</option>
                        <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest Rating</option>
                        <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest Rating</option>
                    </select>

                    <button class="bg-gray-800 text-white px-3 py-2 rounded-3xl text-sm">
                        Apply
                    </button>

                </form>

                <h3 class="text-xl font-bold mb-6">Customer Reviews</h3>

                @forelse($reviews as $review)
                    <div class="bg-white p-4 rounded-xl shadow-sm mb-4">

                        <span class="inline-block bg-green-100 text-black-700 text-xs px-2 py-1 rounded-xl mb-2">
                            Verified Purchase
                        </span>

                        <!-- Stars -->
                        <div class="flex items-center gap-1 mb-2">
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
                        </div>

                        <!-- Comment -->
                        <p class="text-gray-700 text-sm mb-2">
                            {{ $review->comment }}
                        </p>

                        <!-- Date -->
                        <p class="text-xs text-gray-400">
                            {{ $review->created_at->diffForHumans() }}
                        </p>

                        <div class="flex items-center gap-4 mt-3 text-sm">

                            <form method="POST" action="{{ route('reviews.vote', $review) }}">
                                @csrf
                                <input type="hidden" name="is_helpful" value="1">
                                <button class="text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                            stroke-width="2" d="M7 11l5 -8l3 1l-1 6h7v3l-3 7h-11h-4v-9h4v9"/>
                                    </svg> Helpful ({{ $review->votes->where('is_helpful', true)->count() }})
                                </button>
                            </form>

                            <form method="POST" action="{{ route('reviews.vote', $review) }}">
                                @csrf
                                <input type="hidden" name="is_helpful" value="0">
                                <button class="text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                                            stroke-width="2" d="M7 4h11l3 7v3h-7l1 6l-3 1l-5 -8h-4v-9h4v9"/>
                                    </svg> Not Helpful ({{ $review->votes->where('is_helpful', false)->count() }})
                                </button>
                            </form>

                        </div>

                    </div>
                @empty
                    <p class="text-gray-500">No reviews yet.</p>
                @endforelse

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $reviews->withQueryString()->links() }}
                </div>

            </div>

            <!-- SELLER CARD (FULL FIXED VERSION) -->
            <div class="mt-6">

                <div class="bg-white border rounded-xl shadow-sm hover:shadow-md transition p-4">

                    <div class="flex items-center gap-4">

                        <!-- LOGO -->
                        <div class="w-14 h-14 rounded-full overflow-hidden bg-gray-200 flex-shrink-0">

                            @if(optional($product->sellerProfile)->logo)
                                <img src="{{ asset('storage/' . $product->sellerProfile->logo) }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xs text-gray-500">
                                    No Logo
                                </div>
                            @endif

                        </div>

                        <!-- INFO -->
                        <div class="flex-1">

                            <!-- STORE NAME -->
                            <h3 class="font-bold text-gray-800">
                                {{ optional($product->sellerProfile)->store_name ?? 'Seller Store' }}
                            </h3>

                            <!-- STARS -->
                        
                            <div class="flex items-center gap-1 mt-1">

                                <div class="flex items-center gap-1 text-black">
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

                                    <span class="text-gray-500 text-sm ml-1">
                                        ({{ number_format($rating, 1) }})
                                    </span>
                                </div>
                            </div>

                            <!-- META -->
                            <div class="text-xs text-gray-500 mt-1 flex flex-wrap gap-3">

                                @php
                                    // Based on the seller's total orders, not just this product
                                    $sales = $totalSales ?? 0;
                                    $created = optional($product->sellerProfile)->created_at;

                                    
                                @endphp

                                <span>
                                    {{ $sales }} {{ Str::plural('sale', $sales) }}
                                </span>

                                <span>
                                    Joined {{ $created ? $created->diffForHumans() : 'New seller' }}
                                </span>

                            </div>

                        </div>

                    </div>

                    <!-- BUTTONS (FIXED LAYOUT) -->
                    <div class="mt-4 flex gap-2">

                        <!-- VIEW STORE -->
                        <a href="{{ route('store.show', $product->seller_profile_id) }}"
                        class="flex-1 text-center bg-white hover:bg-gray-200 text-black py-2 rounded-3xl text-sm border border-gray-400 shadow-md">
                            View Store
                        </a>

                        <!-- MESSAGE SELLER (FIXED) -->
                        <a href="{{ url('/chat/start/' . $product->seller_profile_id) }}"
                        class="flex-1 text-center bg-white hover:bg-blue-400 text-Black py-2 rounded-3xl text-sm border border-gray-400 shadow-md">
                            Message Seller
                        </a>

                    </div>

                </div>

            </div>

            <!-- RELATED PRODUCTS -->
            <div>
                <h3 class="text-2xl font-bold mb-4 mt-4">
                    Related Products
                </h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            
                    @foreach($related as $item)
                        @php 
                            $image = $item->images->first();
                            $rating = round($item->reviews->avg('rating'), 1);
                        @endphp
                        <a href="/products/{{ $item->id }}" 
                         class="relative group block bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden group hover:scale-105">
                            <div class="p-2">
                                <!-- PRODUCT IMAGE-->
                                @if($image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                        class="w-full h-80 object-cover rounded-xl mb-3 transition-transform">
                                @else
                                    <div class="w-full h-80 object-cover flex items-center justify-center rounded-xl mb-3 transition-transform">
                                            No Image
                                    </div>
                                @endif
                                <h3  class="font-semibold text-lg text-gray-800 group-hover:text-blue-600 transition">
                                    {{ $item->name }}
                                </h3>

                                <!--PRODUCT RATING STARS-->
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
                                        {{ $item->condition == 'new' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ ucfirst(str_replace('_', ' ', $item->condition)) }}
                                </span>

                                <!-- PRICE -->
                                @if($item->is_on_sale)
                                    <div class="flex items-center gap-2 mb-3 mt-3">
                                        <span class="text-blue-600 font-bold text-lg">
                                            R{{ number_format($item->discounted_price, 2) }} 
                                        </span>
                                        <span class="text-gray-400 line-through text-sm">
                                            R{{ number_format($item->price, 2) }} 
                                        </span>
                                    </div>
                                @else
                                    <p class="font-bold text-gray-900  mb-3 mt-3">
                                        R{{ number_format($item->price, 2) }}
                                    </p>
                                @endif

                                @if($item->free_shipping)
                                    <span class="text-xs bg-green-100 text-black px-2 py-1 rounded-xl mt-1 inline-block">
                                        FREE Shipping
                                    </span>
                                @endif

                                @auth
                                    <form method="POST" action="{{ route('wishlist.toggle', $item) }}"
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

          
        </div>
    </div>

    <!-- LIGHTBOX MODAL -->
    <div id="lightbox" class="fixed inset-0 bg-black/90 z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-3xl w-full">
            <img id="lightboxImage" class="w-full max-h-[80vh] object-contain rounded-xl shadow-lg">
            <button onclick="closeLightbox()" 
                    class="absolute top-2 right-2 text-white text-3xl font-bold bg-black/50 rounded-full w-10 h-10 flex items-center justify-center hover:bg-black/70 transition">
                &times;
            </button>
        </div>
    </div>

    <script>
        let images = @json($product->images->pluck('image_path')->map(fn($img) => asset('storage/' . $img)));
        let currentIndex = 0;
        let autoPlayInterval = null;

        function updateImage() {
            if(images.length>0) {
                document.getElementById('mainImage').src = images[currentIndex];
            }
        }

        function changeImage(index) {
            currentIndex = index;
            updateImage();
        }

        function nextImage() {
            if(images.length === 0) return;
            currentIndex = (currentIndex + 1) % images.length;
            updateImage();
        }

        function prevImage() {
            if(images.length === 0) return;
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateImage();
        }

        // LIGHTBOX
        function openLightbox(index) {
            currentIndex = index;
            document.getElementById('lightboxImage').src = images[currentIndex];
            document.getElementById('lightbox').classList.remove('hidden');
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
        }

        // AUTO-PLAY
        function startCarousel() {
            autoPlayInterval = setInterval(nextImage, 5000); // 5s
        }
        function stopCarousel() {
            clearInterval(autoPlayInterval);
        }

        document.getElementById('mainImage').addEventListener('mouseenter', stopCarousel);
        document.getElementById('mainImage').addEventListener('mouseleave', startCarousel);
        startCarousel();

        // MOBILE SWIPE SUPPORT
        let touchStartX = 0;
        let touchEndX = 0;
        const mainImageContainer = document.getElementById('mainImage');
        mainImageContainer.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; });
        mainImageContainer.addEventListener('touchend', e => { 
            touchEndX = e.changedTouches[0].screenX;
            if(touchEndX < touchStartX - 30) nextImage();
            if(touchEndX > touchStartX + 30) prevImage();
        });

        // QUANTITY CONTROLS
        function increaseQty(){ let input=document.getElementById('qty'); input.value=parseInt(input.value)+1; }
        function decreaseQty(){ let input=document.getElementById('qty'); if(input.value>1) input.value--; }

        //DESCRIPTION SCROLL 
        document.addEventListener('DOMContentLoaded', function () {

            const descBox = document.getElementById('descriptionBox');

            let scrollTimeout;

            descBox.addEventListener('scroll', () => {

                // Show scrollbar when scrolling
                descBox.classList.add('show-scrollbar');

                clearTimeout(scrollTimeout);

                // Hide after user stops scrolling
                scrollTimeout = setTimeout(() => {
                    descBox.classList.remove('show-scrollbar');
                }, 800);

            });

        });

    </script>

</x-app-layout>