<x-app-layout>

<div class="bg-gray-100 min-h-screen py-6">

    <!-- HERO WRAPPER -->
    <div class="max-w-7xl mx-auto px-4">

        <!-- HERO BANNER -->
        <div
            class="relative h-[420px] md:h-[520px] overflow-hidden rounded-3xl shadow-xl"
            x-data="heroSlider()"
            x-init="start()">

            <!-- SLIDES -->
            <template x-for="(slide,index) in slides" :key="index">

                <div
                    x-show="active === index"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 scale-105"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-500"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    x-cloak
                    class="absolute inset-0">

                    <!-- Background -->
                    <div
                        class="w-full h-full bg-cover bg-center flex items-center justify-center"
                        :style="`background-image:url(${slide.image})`">

                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-black/60"></div>

                        <!-- CONTENT -->
                        <div class="relative text-center text-white max-w-2xl px-6">

                            <h1 class="text-3xl md:text-5xl font-bold leading-tight"
                                x-text="slide.title"></h1>

                            <p class="mt-4 text-lg opacity-90"
                               x-text="slide.subtitle"></p>

                            <div class="mt-8 flex justify-center gap-4">

                                <a href="{{route('marketplace.index')}}"
                                   class="bg-white text-black px-6 py-3 rounded-3xl font-semibold hover:bg-gray-200 transition">
                                    Shop Now
                                </a>
                            </div>

                        </div>

                    </div>

                </div>

            </template>

            <!-- INDICATORS -->
            <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2">
                <template x-for="(slide,index) in slides" :key="index">
                    <button
                        @click="active = index"
                        class="w-3 h-3 rounded-full transition"
                        :class="active === index ? 'bg-white' : 'bg-white/40'">
                    </button>
                </template>
            </div>

        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 py-10">

        <!-- TOP STORES -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold">Top Stores</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6 mb-12">
            @foreach($topStores as $store)
                <a href="{{ route('store.show', $store->id) }}"
                   class="bg-white p-4 rounded-2xl shadow-sm hover:shadow-lg transition text-center relative group">

                    @if($loop->first)
                        <span class="absolute top-2 left-2 text-xs bg-yellow-400 px-2 py-1 rounded-xl font-semibold">
                            Top Seller
                        </span>
                    @endif

                    @if($loop->iteration == 2)
                        <span class="absolute top-2 left-2 text-xs bg-gray-400 px-2 py-1 rounded-xl font-semibold">
                            2nd Place
                        </span>
                    @endif

                    @if($loop->iteration == 3)
                        <span class="absolute top-2 left-2 text-xs bg-yellow-700 px-2 py-1 rounded-xl font-semibold">
                            3rd Place
                        </span>
                    @endif

                    @if($loop->iteration > 3)
                        <span class="absolute top-2 left-2 text-xs bg-gray-300 px-2 py-1 rounded-xl font-semibold">
                            {{ $loop->iteration }}th Place
                        </span>
                    @endif

                    <img src="{{ $store->logo ? asset('storage/'.$store->logo) : '/default-store.png' }}"
                         class="h-16 w-16 rounded-full mx-auto mb-3 object-cover group-hover:scale-105 transition">

                    <p class="font-semibold text-gray-800 group-hover:text-blue-600">
                        {{ $store->store_name }}
                    </p>
                </a>
            @endforeach
        </div>

        <!-- FEATURED PRODUCTS -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold">Featured Products</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

         @foreach($featuredProducts as $product)

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
                        <span class="{{ $i <= floor($rating) ? 'text-black' : 'text-gray-300' }}">
                           <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                              <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                 stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                 0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                 <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                 <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                              </path>
                           </svg>
                        </span>
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
               <p class="font-bold mt-2 text-gray-900">
                     R{{ number_format($product->price, 2) }}
               </p>

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

    </div>

</div>


<!-- HERO SLIDER SCRIPT -->
<script>
function heroSlider() {
    return {
        active: 0,
        interval: null,

        slides: [
            {
                title: 'Support Local Sellers',
                subtitle: 'Empowering small businesses',
                image: @json(asset('images/flag.jpg'))
            },
            {
                title: 'Discover Handmade Goods',
                subtitle: 'Unique, one-of-a-kind products',
                image: @json(asset('images/handmade.jpg'))
            },
            {
                title: 'Fair Prices, Real Impact',
                subtitle: 'Transparent and ethical trade',
                image: @json(asset('images/community.jpg'))
            }
        ],

        start() {
            this.interval = setInterval(() => {
                this.active = (this.active + 1) % this.slides.length
            }, 7000)
        }
    }
}
</script>

</x-app-layout>