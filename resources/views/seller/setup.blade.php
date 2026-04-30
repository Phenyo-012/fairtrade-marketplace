<x-app-layout>

    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-xl shadow">

        <h2 class="text-2xl font-bold mb-3">Become a Seller</h2>

        <p class="text-gray-600 mb-6">
            Start your seller setup. You will add your store details, pickup address, and verification documents in the next steps.
        </p>

        <form method="POST" action="{{ route('seller.store') }}">
            @csrf

            <button class="bg-black text-white px-6 py-3 rounded-3xl hover:bg-gray-800 shadow-md">
                Start Seller Setup
            </button>
        </form>

    </div>

</x-app-layout>