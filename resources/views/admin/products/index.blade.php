<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-7xl mx-auto px-4">

        <h2 class="text-2xl font-bold mb-6">
            Products Pending Approval
        </h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($products->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <p class="text-gray-500">No products awaiting approval.</p>
            </div>
        @else

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($products as $product)

                @php
                    $image = $product->images->first();
                @endphp

                <div class="bg-white rounded-xl shadow hover:shadow-md transition p-4 flex flex-col">

                    <!-- IMAGE -->
                    <div class="w-full h-48 mb-3 overflow-hidden rounded-xl">
                        <img 
                            src="{{ $image ? asset('storage/' . $image->image_path) : '/placeholder.png' }}"
                            class="w-full h-full object-cover"
                        >
                    </div>

                    <!-- INFO -->
                    <h3 class="font-semibold text-lg text-gray-800">
                        {{ $product->name }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Seller: {{ $product->sellerProfile->store_name ?? 'N/A' }}
                    </p>

                    <p class="font-bold text-blue-600 mt-2">
                        R{{ number_format($product->price, 2) }}
                    </p>

                    <p class="text-xs text-gray-400 mt-2 line-clamp-2">
                        {{ $product->description }}
                    </p>

                    <!-- ACTIONS -->
                    <div class="mt-auto pt-4 flex gap-2">

                        <!-- Approve -->
                        <form method="POST" action="{{ route('admin.products.approve', $product->id) }}" class="flex-1">
                            @csrf
                            <button class="w-full bg-green-600 text-white py-2 rounded-xl hover:bg-green-700 transition">
                                Approve
                            </button>
                        </form>

                        <!-- Optional Reject (future) -->
                        <!--
                        <button class="flex-1 bg-red-500 text-white py-2 rounded-xl">
                            Reject
                        </button>
                        -->

                    </div>

                </div>

            @endforeach

        </div>

        @endif

    </div>

</div>

</x-app-layout>