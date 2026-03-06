<x-app-layout>

<h2>{{ $product->name }}</h2>

<p><strong>Seller:</strong> {{ $product->sellerProfile->store_name }}</p>

<p><strong>Price:</strong> ${{ $product->price }}</p>

<p><strong>Stock:</strong> {{ $product->stock_quantity }}</p>

<p><strong>Category:</strong> {{ $product->category }}</p>

<p><strong>Condition:</strong> {{ $product->condition }}</p>

<p>{{ $product->description }}</p>

</x-app-layout>