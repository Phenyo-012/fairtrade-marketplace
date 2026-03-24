<x-app-layout>
<div class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow">

        <h2 class="text-2xl font-bold mb-6">Checkout</h2>

        @foreach($items as $item)
            <div class="flex justify-between mb-2">
                <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                <span>R{{ number_format($item->product->price * $item->quantity, 2) }}</span>
            </div>
        @endforeach

        <div class="border-t mt-4 pt-4 flex justify-between font-bold">
            <span>Total</span>
            <span>R{{ number_format($total, 2) }}</span>
        </div>

        <form method="POST" action="{{ route('checkout.store') }}" class="mt-6">
            @csrf

            <button class="w-full bg-green-600 text-white py-3 rounded hover:bg-green-700">
                Confirm Order
            </button>
        </form>

    </div>

</div>
</x-app-layout>