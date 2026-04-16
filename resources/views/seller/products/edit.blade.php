<x-app-layout>

<div class="max-w-2xl mx-auto mt-10">

<h2 class="text-xl font-bold mb-4">Edit Product</h2>

<form method="POST" action="{{ route('seller.products.update',$product) }}">
@csrf
@method('PUT')

<input name="name" value="{{ $product->name }}" class="border p-2 w-full mb-2">

<textarea name="description"
class="border p-2 w-full mb-2">{{ $product->description }}</textarea>

<input name="price" value="{{ $product->price }}"
       class="border p-2 w-full mb-2">

<input name="stock_quantity" value="{{ $product->stock_quantity }}"
       class="border p-2 w-full mb-2">

<select name="category" class="w-full border rounded p-2 mb-4" required>
    <option value="">Select Category</option>

    @foreach(config('categories') as $main => $subs)
        <optgroup label="{{ $main }}">
            @foreach($subs as $sub)
                <option value="{{ $sub }}">{{ $sub }}</option>
            @endforeach
        </optgroup>
    @endforeach
</select>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
Update
</button>

</form>

</div>

</x-app-layout>