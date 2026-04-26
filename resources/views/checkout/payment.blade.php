@php 
    use Illuminate\Support\Str; 
@endphp
<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">

            <h2 class="text-2xl font-bold mb-2">Payment</h2>

            <p class="text-gray-500 mb-6">
                Total amount: <span class="font-bold text-black">R{{ number_format($total, 2) }}</span>
            </p>

            @if($paymentMethod === 'card')
                <div class="bg-gray-50 p-5 rounded-xl mb-6">
                    <h3 class="font-bold mb-4">Card Payment</h3>

                    <input type="text" placeholder="Card Number"
                        class="w-full border p-3 rounded-xl mb-3">

                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" placeholder="MM/YY"
                            class="border p-3 rounded-xl">

                        <input type="text" placeholder="CVV"
                            class="border p-3 rounded-xl">
                    </div>

                    <input type="text" placeholder="Cardholder Name"
                        class="w-full border p-3 rounded-xl mt-3">

                    <p class="text-xs text-gray-500 mt-3">
                        Simulation only. No real payment will be processed.
                    </p>
                </div>
            @endif

            @if($paymentMethod === 'eft')
                <div class="bg-gray-50 p-5 rounded-xl mb-6">
                    <h3 class="font-bold mb-4">EFT / Bank Transfer</h3>

                    <div class="space-y-2 text-sm">
                        <p><strong>Bank:</strong> FairTrade Demo Bank</p>
                        <p><strong>Account Name:</strong> FairTrade Escrow</p>
                        <p><strong>Account Number:</strong> 1234567890</p>
                        <p><strong>Branch Code:</strong> 250655</p>
                        <p><strong>Reference:</strong> FT-{{ strtoupper(Str::random(8)) }}</p>
                    </div>

                    <p class="text-xs text-gray-500 mt-4">
                        Simulation only. You can skip proof of payment for now.
                    </p>
                </div>
            @endif

            @if($paymentMethod === 'ozow')
                <div class="bg-gray-50 p-5 rounded-xl mb-6">
                    <h3 class="font-bold mb-4">Ozow Instant EFT</h3>

                    <p class="text-gray-600 mb-4">
                        You would normally be redirected to Ozow to securely choose your bank and approve the payment.
                    </p>

                    <div class="border rounded-xl p-4 bg-white">
                        <p class="font-semibold">Ozow Simulation</p>
                        <p class="text-sm text-gray-500">
                            Select bank → approve payment → return to FairTrade.
                        </p>
                    </div>
                </div>
            @endif

            @if($paymentMethod === 'cod')
                <div class="bg-gray-50 p-5 rounded-xl mb-6">
                    <h3 class="font-bold mb-4">Cash on Delivery</h3>

                    <p class="text-gray-600">
                        You will pay the courier when your order is delivered.
                    </p>

                    <p class="text-sm text-green-600 mt-3">
                        Cash on Delivery approved for this order.
                    </p>
                </div>
            @endif

           <form method="POST" action="{{ route('checkout.payment.confirm') }}">
                @csrf

                <button class="w-full bg-green-600 text-black font-semibold py-3 rounded-3xl hover:bg-green-700 transition">
                    Simulate Payment & Place Order
                </button>
            </form>

            <a href="{{ route('checkout.index') }}"
            class="block text-center mt-4 text-sm text-blue-600 hover:underline">
                Back to checkout
            </a>

        </div>
    </div>
</x-app-layout>