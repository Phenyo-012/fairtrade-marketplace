<x-app-layout>

<div class="max-w-4xl mx-auto mt-10">

@if($product->image)
<img src="{{ asset('storage/' . $product->image) }}"
     alt="{{ $product->name }}"
     class="w-full max-h-96 object-cover mb-4 rounded">
@endif

<h2 class="text-2xl font-bold mb-4">
{{ $product->name }}
</h2>

<p class="text-gray-700 mb-4">
{{ $product->description }}
</p>

<p class="text-xl font-bold mb-4">
${{ $product->price }}
</p>

<p class="mb-4">
Stock: {{ $product->stock_quantity }}
</p>

<form method="POST" action="/products/{{ $product->id }}/buy">
@csrf

<input type="number" name="quantity" value="1"
       class="border p-2 w-20 mb-3">

<button class="bg-blue-600 text-white px-4 py-2 rounded">
Buy Now
</button>

</form>

</div>

</x-app-layout>