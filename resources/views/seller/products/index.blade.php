<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-7xl mx-auto px-4">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">
                My Products
            </h2>

            <a href="{{ route('seller.products.create') }}"
               class="px-4 py-2 bg-white text-black border border-black rounded-3xl hover:bg-blue-300 transition shadow-md">
                + Add Product
            </a>
        </div>

        <!-- Product Grid -->
        <div class="grid gap-6
                    grid-cols-1
                    sm:grid-cols-2
                    lg:grid-cols-3
                    max-w-6xl mx-auto">

        @forelse($products as $product)

        <!-- Product Card -->
        <div class="relative bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 overflow-hidden flex flex-col">

            <!-- Image -->
            <div class="w-full h-80 object-cover rounded-xl mb-3 transition-transform">
                @if($product->images->count())
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-80 object-cover flex items-center justify-center rounded-xl mb-3 transition-transform">
                        No Image
                    </div>
                @endif
            </div>

            <!-- Content -->
            <div class="p-4 flex flex-col flex-1">

                <div class="space-y-1">
                    <h3 class="font-semibold text-base text-gray-900 line-clamp-2">
                        {{ $product->name }}
                    </h3>

                    @if($product->is_on_sale)
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-blue-600 font-bold text-lg">
                                R{{ number_format($product->discounted_price, 2) }} 
                            </span>

                            <span class="text-gray-400 line-through text-sm">
                                R{{ number_format($product->price, 2) }} 
                            </span>
                            <p class="text-gray-400 text-sm">
                                ({{ $product->discount_percentage }}% OFF)
                            </p>
                        </div>
                    @else
                        <p class="font-bold text-gray-900">
                            R{{ number_format($product->price, 2) }}
                        </p>
                    @endif

                    @if($product->free_shipping)
                        <span class="text-xs bg-green-100 text-black px-2 py-1 rounded-xl mt-1 inline-block">
                            FREE Shipping
                        </span>
                    @endif

                    @if($product->is_archived)
                        <span class="absolute top-3 left-4 bg-gray-900/90 backdrop-blur text-white text-xs font-semibold px-3 py-1 rounded-full shadow">
                            Archived
                        </span>
                    @endif

                    <!-- Stock Badge -->
                    <span class="inline-block text-xs px-2 py-1 rounded-full
                        @if($product->stock_quantity < 5)
                            bg-red-100 text-red-700
                        @else
                            bg-green-100 text-green-700
                        @endif">
                        {{ $product->stock_quantity }} in stock
                    </span>
                </div>

                <!-- Actions -->
                <div class="flex gap-4 mt-auto pt-4">

                    <a href="{{ route('seller.products.edit', $product) }}"
                    class="flex-1 text-center py-2 text-sm border border-black rounded-full hover:bg-blue-300 transition">
                        Edit
                    </a>

                    @if(!$product->is_archived)
                        <form method="POST" action="{{ route('products.archive', $product) }}" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button class="w-full py-2 text-sm border border-black rounded-full hover:bg-yellow-600 transition">
                                Archive
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('products.unarchive', $product) }}" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button class="w-full py-2 text-sm border border-black rounded-full hover:bg-green-600 transition">
                                Restore
                            </button>
                        </form>
                    @endif

                    <form method="POST"
                        action="{{ route('seller.products.destroy', $product) }}"
                        class="flex-1"
                        onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone!');">
                        @csrf
                        @method('DELETE')

                        <button class="w-full py-2 text-sm border border-black rounded-full hover:bg-red-300 transition">
                            Delete
                        </button>
                    </form>

                </div>

            </div>
        </div>

        @empty

        <div class="col-span-full text-center text-gray-500">
            No products yet.
        </div>

        @endforelse

        </div>

    </div>
</div>

</x-app-layout>