<x-app-layout>

    <div class="max-w-5xl mx-auto py-2 px-4">

          <!-- BACK TO DISPUTES INDEX -->
        <a href="{{ route('seller.disputes.index') }}" class="px-4 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                </path>
            </svg>
        </a>

        <h2 class="text-xl font-bold mb-4">Dispute</h2>

        <div class="bg-white p-6 rounded-xl shadow space-y-4">

            <p><strong>Buyer Reason:</strong></p>
            <p class="bg-gray-100 p-3 rounded-xl">{{ $dispute->reason }}</p>

            @if($dispute->seller_response)
                <p><strong>Your Response:</strong></p>
                <p class="bg-blue-100 p-3 rounded-xl">{{ $dispute->seller_response }}</p>
            @else

                <form method="POST" action="{{ route('seller.disputes.respond', $dispute) }}">
                    @csrf

                    <textarea name="response"
                        class="w-full border rounded-xl p-2"
                        placeholder="Explain your side..."
                        required></textarea>

                    <button class="px-4 py-2 mt-2 bg-white text-black border border-black rounded-3xl hover:bg-green-600 transition shadow-md">
                        Submit Response
                    </button>
                </form>

            @endif

        </div>

    </div>

</x-app-layout>