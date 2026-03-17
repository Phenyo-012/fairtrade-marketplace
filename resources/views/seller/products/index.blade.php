<x-app-layout>

<div class="max-w-6xl mx-auto mt-10">

<h2 class="text-2xl font-bold mb-6">My Products</h2>

<a href="{{ route('seller.products.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
   Add Product
</a>

<table class="w-full border">

<tr class="bg-gray-200">
<th class="p-2">Name</th>
<th class="p-2">Price</th>
<th class="p-2">Stock</th>
<th class="p-2">Actions</th>
</tr>

@foreach($products as $product)

<tr class="border-t">
@if($product->image)
<td class="p-2">
   <img src="{{ asset('storage/' . $product->image) }}"
      alt="{{ $product->name }}"
      class="w-20 h-20 object-cover rounded">
</td>
@else
<td class="p-2">No Image</td>
@endif
<td class="p-2">{{ $product->name }}</td>
<td class="p-2">${{ $product->price }}</td>
<td class="p-2">{{ $product->stock_quantity }}</td>

<td class="p-2 space-x-2">

<a href="{{ route('seller.products.edit',$product) }}"
   class="bg-yellow-500 text-black px-2 py-1 rounded">
   Edit Listing
</a>

<form method="POST"
      action="{{ route('seller.products.destroy',$product) }}"
      class="inline">

@csrf
@method('DELETE')

<button class="text-black px-2 py-1 rounded">
Delete Listing
</button>

</form>

</td>

</tr>

@endforeach

</table>

</div>

</x-app-layout>