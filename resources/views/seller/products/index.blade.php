<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-7xl mx-auto px-4">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">
                My Products
            </h2>

            <a href="{{ route('seller.products.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Add Product
            </a>
        </div>

        <!-- Product Grid -->
        <div class="grid gap-4 mb-6 w-full
                    grid-cols-1
                    md:grid-cols-products-md
                    lg:grid-cols-products-lg
                    justify-center">

            @forelse($products as $product)

            <!-- Product Card -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden text-sm h-[420px] flex flex-col">

                <!-- Image -->
                <div class="w-full h-48 overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-500">
                            No Image
                        </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-4 flex-1 flex flex-col justify-between">

                    <div class="space-y-2">
                        <h3 class="font-semibold text-lg text-black line-clamp-2">
                            {{ $product->name }}
                        </h3>

                        <p class="text-gray-700 font-semibold text-sm">
                            R{{ number_format($product->price, 2) }}
                        </p>

                        <!-- Stock Badge -->
                        <span class="inline-block py-0.5 px-2 text-xs rounded-full
                            @if($product->stock_quantity < 5)
                                bg-red-100 text-red-700
                            @else
                                bg-green-100 text-green-700
                            @endif">
                            {{ $product->stock_quantity }} in stock
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2 pt-4">
                        <a href="{{ route('seller.products.edit', $product) }}"
                           class="flex-1 text-center text-black font-semibold py-2 rounded-lg border">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('seller.products.destroy', $product) }}"
                              class="flex-1">
                            @csrf
                            @method('DELETE')

                            <button class=" w-full flex-1 text-center text-black font-semibold py-2 rounded-lg border">
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