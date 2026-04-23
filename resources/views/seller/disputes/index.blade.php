<x-app-layout>

    <div class="max-w-5xl mx-auto mt-5">

        <!-- BACK TO SELLER DASHBOARD -->
        <a href="{{ route('seller.dashboard') }}" class="px-4 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                </path>
            </svg>
        </a>

        <h2 class="text-xl font-bold mb-6">Disputes</h2>

        @foreach($disputes as $dispute)
            <div class="bg-white p-4 rounded-xl shadow mb-3 flex justify-between">
                <div>
                    <p>Order #{{ $dispute->order_id }}</p>
                    <p class="text-sm text-gray-500">{{ $dispute->status }}</p>
                </div>

                <a href="{{ route('seller.disputes.show', $dispute) }}"
                class="w-28 bg-white text-black text-center justify-center py-2 border border-black rounded-3xl hover:bg-blue-300 transition shadow-md">
                View
                </a>
            </div>
        @endforeach

    </div>

</x-app-layout>