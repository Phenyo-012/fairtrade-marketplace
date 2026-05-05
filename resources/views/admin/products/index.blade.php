<x-app-layout>
    <div class="max-w-6xl mx-auto mt-5 px-4 pb-10">

        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                </path>
            </svg>
        </a>

        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-6">
            <div>
                <h2 class="text-2xl font-bold">
                    Product Approval Status
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Review pending products and confirm which products are already approved or active.
                </p>
            </div>

            <div class="text-sm text-gray-500">
                Total products shown: <span class="font-semibold text-black">{{ $products->count() }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($products->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <p class="text-gray-500">No products found.</p>
            </div>
        @else

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach($products as $product)

                    @php
                        $image = $product->images->first();
                        $sellerStatus = $product->sellerProfile->verification_status ?? 'missing';
                    @endphp

                    <div class="bg-white rounded-xl shadow hover:shadow-md transition p-4 flex flex-col">

                        <!-- IMAGE -->
                        <div class="w-full h-48 mb-3 overflow-hidden rounded-xl bg-gray-100">
                            <img 
                                src="{{ \App\Support\ImageUrl::make($image->image_path ?? null, 'placeholder.png') }}"
                                class="w-full h-full object-cover"
                                alt="{{ $product->name }}">
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

                        <!-- PRODUCT STATUS BADGES -->
                        <div class="flex flex-wrap gap-2 mt-3 text-xs">

                            <span class="px-2 py-1 rounded-full {{ $product->is_approved ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $product->is_approved ? 'Approved' : 'Pending Approval' }}
                            </span>

                            <span class="px-2 py-1 rounded-full {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>

                            <span class="px-2 py-1 rounded-full {{ $product->is_archived ? 'bg-gray-200 text-gray-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $product->is_archived ? 'Archived' : 'Not Archived' }}
                            </span>

                        </div>

                        <!-- SELLER STATUS -->
                        <div class="mt-3 text-xs">
                            <span class="font-semibold text-gray-600">Seller status:</span>

                            <span class="px-2 py-1 rounded-full
                                @if($sellerStatus === 'approved') bg-green-100 text-green-700
                                @elseif($sellerStatus === 'pending') bg-yellow-100 text-yellow-700
                                @elseif($sellerStatus === 'rejected') bg-red-100 text-red-700
                                @elseif($sellerStatus === 'archived') bg-gray-200 text-gray-700
                                @else bg-red-100 text-red-700
                                @endif
                            ">
                                {{ ucfirst($sellerStatus) }}
                            </span>
                        </div>

                        <p class="text-xs text-gray-400 mt-3 line-clamp-2">
                            {{ $product->description }}
                        </p>

                        <!-- DEBUG INFO -->
                        <div class="mt-4 bg-gray-50 rounded-xl p-3 text-xs text-gray-600 space-y-1">
                            <p><span class="font-semibold">Product ID:</span> {{ $product->id }}</p>
                            <p><span class="font-semibold">Seller Profile ID:</span> {{ $product->seller_profile_id ?? 'N/A' }}</p>
                            <p><span class="font-semibold">Created:</span> {{ $product->created_at?->format('d M Y H:i') }}</p>
                        </div>

                        <!-- ACTIONS -->
                        <div class="mt-auto pt-4 flex gap-2">

                            @if(!$product->is_approved || !$product->is_active || $product->is_archived)
                                <form method="POST" action="{{ route('admin.products.approve', $product->id) }}" class="flex-1">
                                    @csrf
                                    <button class="w-full px-4 py-2 bg-white text-black border border-black rounded-3xl hover:bg-green-600 hover:text-white transition shadow-md">
                                        Approve / Activate
                                    </button>
                                </form>
                            @else
                                <div class="flex-1 px-4 py-2 bg-green-100 text-green-700 rounded-3xl text-center text-sm font-semibold">
                                    Already Approved
                                </div>
                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @endif
    </div>
</x-app-layout>