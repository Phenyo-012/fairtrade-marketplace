<x-app-layout>

<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

<h2 class="text-2xl font-bold mb-4">Order Placed Successfully</h2>

<p class="mb-4">
Your order has been created.
</p>

<div class="bg-green-100 p-4 rounded-xl text-center">

<p class="text-lg font-semibold">Your Delivery Code</p>

<p class="text-3xl font-bold text-green-700">
{{ $order->delivery_code }}
</p>

<p class="mt-2 text-sm text-gray-600">
Give this code to the courier when your package arrives.
</p>

</div>

</div>

</x-app-layout>