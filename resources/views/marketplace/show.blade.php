<x-app-layout>

<h2>{{ $product->name }}</h2>

<p><strong>Seller:</strong> {{ $product->sellerProfile->store_name }}</p>

<p><strong>Price:</strong> ${{ $product->price }}</p>

<p><strong>Stock:</strong> {{ $product->stock_quantity }}</p>

<p><strong>Category:</strong> {{ $product->category }}</p>

<p><strong>Condition:</strong> {{ $product->condition }}</p>

<p>{{ $product->description }}</p>

@if(auth()->check())

<form method="POST" action="/products/{{ $product->id }}/buy">

    @csrf

    <label>Quantity:</label>

    <input type="number"
           name="quantity"
           value="1"
           min="1"
           max="{{ $product->stock_quantity }}">

    <button type="submit">
        Buy Now
    </button>

</form>

@endif

</x-app-layout>