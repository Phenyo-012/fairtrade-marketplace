<x-app-layout>

<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">

    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">

        <h2 class="text-2xl font-bold text-center mb-6">
            Courier Delivery Confirmation
        </h2>

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR --}}
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('courier.confirm') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Delivery Code
                </label>

                <input type="text"
                       name="delivery_code"
                       required
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Enter delivery code">
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                Confirm Delivery
            </button>
        </form>

        <p class="text-xs text-gray-500 text-center mt-4">
            Enter the code provided by the buyer upon delivery.
        </p>

    </div>

</div>

</x-app-layout>