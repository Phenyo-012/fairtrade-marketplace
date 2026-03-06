<x-app-layout>

<h2>Marketplace</h2>

<table border="1">

<thead>
<tr>
<th>Product</th>
<th>Seller</th>
<th>Price</th>
<th>Stock</th>
</tr>
</thead>

<tbody>

@foreach($products as $product)

<tr>

<td>{{ $product->name }}</td>

<td>{{ $product->sellerProfile->store_name }}</td>

<td>${{ $product->price }}</td>

<td>{{ $product->stock_quantity }}</td>

</tr>

@endforeach

</tbody>

</table>

</x-app-layout>