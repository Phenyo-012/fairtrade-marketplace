@php use Illuminate\Support\Str; @endphp
<x-app-layout>

   <div class="max-w-7xl mx-auto mt-10">

      <!-- <h2 class="text-2xl font-bold mb-6">Marketplace</h2> -->

      <!-- FILTER -->
      <form method="GET" class="mb-6 flex gap-2 mt-6">

        <div class="relative inline-block" id="categoryMenu">

         <!-- Trigger Button -->
         <button
            type="button"
            id="categoryTrigger"
            class="flex items-center justify-between border border-gray-400 px-4 py-2 rounded-2xl w-60 bg-white hover:bg-gray-50"
            aria-haspopup="true"
            aria-expanded="false">

            <span>
                  Category:
                  <span id="selectedCategory">All Categories</span>
            </span>

            <!-- Caret -->
            <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                  <path d="M7 10l5 5 5-5z"/>
            </svg>
         </button>

         <!-- Dropdown Menu -->
         <div
            id="categoryDropdown"
            class="hidden absolute right-0 mt-2 w-60 bg-white border rounded-xl shadow-lg z-50">

            <button class="menu-item block w-full text-left px-4 py-2 hover:bg-gray-100" data-value="">
                  All Categories
            </button>

            <button class="menu-item block w-full text-left px-4 py-2 hover:bg-gray-100" data-value="electronics">
                  Electronics
            </button>

            <button class="menu-item block w-full text-left px-4 py-2 hover:bg-gray-100" data-value="fashion">
                  Fashion
            </button>

            <button class="menu-item block w-full text-left px-4 py-2 hover:bg-gray-100" data-value="home">
                  Home
            </button>

         </div>

         <!-- Hidden input (replaces select) -->
         <input type="hidden" name="category" id="categoryInput">

      </div>

      </form>

      <!-- Products Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

         @foreach($products as $product)

         <a href="/products/{{ $product->id }}" 
            class="relative group block bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden group hover:scale-105">

            <div class="p-4">

               <!-- IMAGE -->
               @if($product->images->count())
                     <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-80 object-cover rounded mb-3 transition-transform">
               @else
                     <img src="/placeholder.png" 
                        class="w-full h-80 object-cover rounded mb-3 transition-transform"
                        alt="no image">
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
                        <span class="{{ $i <= floor($rating) ? 'text-yellow-400' : 'text-gray-300' }}">
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
               <span class="text-xs px-2 py-1 rounded inline-block mt-1
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

   // Toggle menu
   trigger.addEventListener("click", () => {
      dropdown.classList.toggle("hidden");
   });

   // Select option
   document.querySelectorAll(".menu-item").forEach(item => {
      item.addEventListener("click", () => {
         selectedText.textContent = item.textContent;
         hiddenInput.value = item.dataset.value;
         dropdown.classList.add("hidden");
      });
   });

   // Close when clicking outside
   document.addEventListener("click", e => {
      if (!document.getElementById("categoryMenu").contains(e.target)) {
         dropdown.classList.add("hidden");
      }
   });
   </script>
</x-app-layout>