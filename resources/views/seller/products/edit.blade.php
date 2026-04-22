<x-app-layout>

    <div class="max-w-2xl mx-auto mt-5">

        <!-- BACK TO MY PRODUCTS -->
        <a href="{{ route('seller.products.index') }}" class="mt-6 px-4 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                </path>
            </svg>
        </a>

        <h2 class="text-xl font-bold mb-4">Edit Product</h2>

        <form method="POST" action="{{ route('seller.products.update',$product) }}">
            @csrf
            @method('PUT')

            <input name="name" value="{{ $product->name }}" class="border border-gray-400 p-2 w-full mb-2 rounded-xl focus:ring focus:ring-blue-300 focus:outline-none">

            <textarea name="description"
                class="border border-gray-400 p-2 w-full mb-2 rounded-xl focus:ring focus:ring-blue-300 focus:outline-none">{{ $product->description }}</textarea>

            <input name="price" value="{{ $product->price }}"
                class="border border-gray-400 p-2 w-full mb-2 rounded-xl focus:ring focus:ring-blue-300 focus:outline-none">

            <input name="stock_quantity" value="{{ $product->stock_quantity }}"
                class="border border-gray-400 p-2 w-full mb-2 rounded-xl focus:ring focus:ring-blue-300 focus:outline-none">

            <select name="category" class="w-full border-gray-400 rounded-xl p-2 mb-4 focus:ring-blue-300 focus:outline-none" required>
                <option value="">Select Category</option>

                @foreach(config('categories') as $main => $subs)
                    <optgroup label="{{ $main }}">
                        @foreach($subs as $sub)
                            <option value="{{ $sub }}">{{ $sub }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>

            <!-- DISCOUNT -->
            <div>
                <label class="block text-sm font-medium">Discount (%)</label>
                <input type="number" name="discount_percentage"
                    value="{{ old('discount_percentage', $product->discount_percentage) }}"
                    class="w-full border-gray-400 rounded-xl p-2 mb-4 focus:ring-blue-300 focus:outline-none" required"
                    min="0" max="90">
            </div>

            <div>
                <label class="block text-sm font-medium">Discount Duration (hours)</label>
                <input type="number" name="discount_hours"
                    class="w-full border-gray-400 rounded-xl p-2 mb-4 focus:ring-blue-300 focus:outline-none" required"
                    placeholder="e.g. 24">
            </div>

            <!-- FREE SHIPPING -->
            <div class="flex items-center gap-2 mt-3 mb-5">
                <input type="checkbox" class="rounded-full" name="free_shipping" value="1"
                    {{ $product->free_shipping ? 'checked' : '' }}>
                <label>Free Shipping</label>
            </div>

            <button class="px-4 py-2 bg-gray-200 text-black border border-black rounded-3xl hover:bg-blue-300 transition shadow-md">
                Update
            </button>

        </form>

    </div>

</x-app-layout>