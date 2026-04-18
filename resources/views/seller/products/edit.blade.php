<x-app-layout>

    <div class="max-w-2xl mx-auto mt-10">

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

            <button class="px-4 py-2 bg-gray-200 text-black border border-black rounded-3xl hover:bg-blue-300 transition shadow-md">
                Update
            </button>

        </form>

    </div>

</x-app-layout>