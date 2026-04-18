<x-app-layout>

    <div class="max-w-2xl mx-auto mt-10">

    <h2 class="text-xl font-bold mb-4">Add Product</h2>

    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mt-4">
        <label>Product Image</label>
        <input type="file" name="images[]" multiple required
        class="border p-2 w-full">
    </div>

    <input name="name" placeholder="Name" class="border p-2 w-full mb-2">

    <textarea name="description" placeholder="Description"
            class="border p-2 w-full mb-2"></textarea>

    <input name="price" type="number" step="0.01"
        placeholder="Price" class="border p-2 w-full mb-2">

    <input name="stock_quantity" type="number"
        placeholder="Stock" class="border p-2 w-full mb-2">

    <select name="category" class="w-full border rounded-xl p-2 mb-4">
        <option value="">Select Category</option>

        @foreach(config('categories') as $main => $subs)
            <optgroup label="{{ $main }}">
                @foreach($subs as $sub)
                    <option value="{{ $sub }}">{{ $sub }}</option>
                @endforeach
            </optgroup>
        @endforeach
    </select>

    <select name="condition" class="border p-2 w-full mb-4">
    <option value="new">New</option>
    <option value="second_hand">Second Hand</option>
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded-xl">
    Save Product Listing
    </button>

    </form>

    </div>

</x-app-layout>