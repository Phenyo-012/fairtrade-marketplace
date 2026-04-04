<x-app-layout>

<div class="max-w-3xl mx-auto mt-10">

<h2 class="text-xl font-bold mb-4">Dispute</h2>

<div class="bg-white p-6 rounded shadow space-y-4">

    <p><strong>Buyer Reason:</strong></p>
    <p class="bg-gray-100 p-3 rounded">{{ $dispute->reason }}</p>

    @if($dispute->seller_response)
        <p><strong>Your Response:</strong></p>
        <p class="bg-blue-100 p-3 rounded">{{ $dispute->seller_response }}</p>
    @else

        <form method="POST" action="{{ route('seller.disputes.respond', $dispute) }}">
            @csrf

            <textarea name="response"
                class="w-full border rounded p-2"
                placeholder="Explain your side..."
                required></textarea>

            <button class="bg-green-600 text-white px-4 py-2 mt-2 rounded">
                Submit Response
            </button>
        </form>

    @endif

</div>

</div>

</x-app-layout>