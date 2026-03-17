@php use Illuminate\Support\Str; @endphp
<x-app-layout>

<div class="max-w-7xl mx-auto mt-10">

<h2 class="text-2xl font-bold mb-6">Marketplace</h2>

<!-- Search -->
<form method="GET" class="mb-6 flex gap-2">

<input type="text" name="search"
       placeholder="Search products..."
       value="{{ request('search') }}"
       class="border p-2 w-full">

<select name="category" class="border p-2">
<option value="">All Categories</option>
<option value="electronics">Electronics</option>
<option value="fashion">Fashion</option>
<option value="home">Home</option>
</select>

<button class="bg-blue-600 text-white px-4 rounded">
Search
</button>

</form>

<!-- Products Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

@foreach($products as $product)

<div class="border p-4 rounded shadow-sm">

@if($product->image)
<img src="{{ asset('storage/' . $product->image) }}"
     alt="{{ $product->name }}"
     class="w-full h-40 object-cover mb-2 rounded">
@endif

<h3 class="font-bold text-lg">
{{ $product->name }}
</h3>

<p class="text-gray-600 text-sm">
{{ Str::limit($product->description, 60) }}
</p>

<p class="font-bold mt-2">
${{ $product->price }}
</p>

<a href="/products/{{ $product->id }}"
   class="block mt-3 text-black text-center py-1 rounded">
   View
</a>

</div>

@endforeach

</div>

<div class="mt-6">
{{ $products->links() }}
</div>

</div>

</x-app-layout>