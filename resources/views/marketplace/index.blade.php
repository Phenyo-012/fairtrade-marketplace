@php 
   use Illuminate\Support\Str; 
@endphp
<x-app-layout>

   <div class="max-w-7xl mx-auto mt-10">

      <!-- <h2 class="text-2xl font-bold mb-6">Marketplace</h2> -->

      <!-- FILTER BAR -->
      <form method="GET" class="mb-8 space-y-4 mt-6">

         <div class="flex flex-wrap gap-3 items-center">

            <!-- SPECIAL OFFERS -->
            <select name="offer" class="border w-40 px-4 py-2 rounded-3xl focus:ring focus:ring-blue-300 focus:outline-none">
                  <option value="">
                     Special Offers
                  </option>
                  <option value="free_shipping" {{ request('offer') == 'free_shipping' ? 'selected' : '' }}>
                     Free Shipping
                  </option>
            </select>

            <!-- PRICE RANGE -->
            <div class="flex items-center gap-2">
               <input type="number" name="min_price" placeholder="Min"
                  value="{{ request('min_price') }}"
                  class="border px-3 py-2 w-24 rounded-3xl focus:ring focus:ring-blue-300 focus:outline-none">

               <span> - </span>

               <input type="number" name="max_price" placeholder="Max"
                  value="{{ request('max_price') }}"
                  class="border px-3 py-2 w-24 rounded-3xl focus:ring focus:ring-blue-300 focus:outline-none ">
            </div>

            <!-- SORT -->
            <select name="sort" class="border w-[225px] px-4 py-2 rounded-3xl focus:ring focus:ring-blue-300 focus:outline-none">
                  <option value="">
                     Sort By
                  </option>
                  <option value="low_price" {{ request('sort') == 'low_price' ? 'selected' : '' }}>
                     Lowest Price
                  </option>
                  <option value="high_price" {{ request('sort') == 'high_price' ? 'selected' : '' }}>
                     Highest Price
                  </option>
                  <option value="top_reviews" {{ request('sort') == 'top_reviews' ? 'selected' : '' }}>
                     Top Customer Reviews
                  </option>
                  <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>
                     Most Recent
                  </option>
            </select>

            <!-- APPLY -->
            <button class="bg-black text-white px-5 py-2 rounded-3xl shadow-md">
                  Apply
            </button>

            <!-- RESET -->
            <a href="{{ route('marketplace.index') }}"
               class="bg-black text-white px-5 py-2 rounded-3xl shadow-md">
                  Reset
            </a>

         </div>

      </form>

      <!-- Products Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

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
                  <p class="font-bold text-gray-900  mb-3 mt-3">
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

      <!-- Pagination -->
      <div class="mt-6">
         {{ $products->links() }}
      </div>

   </div>

   <script>
      const trigger = document.getElementById("categoryTrigger");
      const dropdown = document.getElementById("categoryDropdown");
      const selectedText = document.getElementById("selectedCategory");
      const hiddenInput = document.getElementById("categoryInput");

      // Open dropdown
      trigger.addEventListener("click", (e) => {
         e.stopPropagation();
         dropdown.classList.toggle("hidden");
      });

      // Select option
      document.querySelectorAll(".menu-item").forEach(item => {
         item.addEventListener("click", () => {

            const value = item.dataset.value;
            const text = item.textContent.trim();

            hiddenInput.value = value;
            selectedText.textContent = text;

            dropdown.classList.add("hidden");
         });
      });

      // Close on outside click
      document.addEventListener("click", (e) => {
         if (!document.getElementById("categoryMenu").contains(e.target)) {
            dropdown.classList.add("hidden");
         }
      });
   </script>
   
</x-app-layout>