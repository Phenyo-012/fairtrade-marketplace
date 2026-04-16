<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-7xl mx-auto px-4">

        <h2 class="text-2xl font-bold mb-6">My Wishlist</h2>

        @if($items->isEmpty())

            <div class="bg-white p-6 rounded-xl shadow text-center">
                <p class="text-gray-500">No items in wishlist.</p>
            </div>

        @else

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

            @foreach($items as $item)
                @php 
                    $image = $item->product->images->first(); 
                @endphp

                <div class="bg-white rounded-xl shadow p-4 relative">

                    <a href="/products/{{ $item->product->id }}">

                        <img src="{{ $image ? asset('storage/' . $image->image_path) : '/placeholder.png' }}"
                             class="w-full h-auto object-cover rounded-xl mb-2">

                        <p class="font-semibold text-sm">
                            {{ $item->product->name }}
                        </p>

                        <p class="text-blue-600 font-bold">
                            R{{ number_format($item->product->price, 2) }}
                        </p>

                    </a>

                    <!-- Remove -->
                    <form method="POST" action="{{ route('wishlist.destroy', $item) }}"
                          class="absolute bottom-1 right-2">
                        @csrf
                        @method('DELETE')

                        <button class="text-red-500 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                viewBox="0 0 24 24">
                                <path fill="none" stroke="#ff0505" stroke-linecap="round" 
                                    stroke-linejoin="round" stroke-width="2" d="M5 5l7 7l7 
                                    -7M12 12h0M5 19l7 -7l7 7">
                                        <animate fill="freeze" attributeName="d" dur="0.74s" 
                                            values="M5 5l7 0l7 0M5 12h14M5 19l7 0l7 0;M5 5l7 7l7 
                                            -7M12 12h0M5 19l7 -7l7 7"/>
                                </path>
                            </svg>
                        </button>
                    </form>

                </div>

            @endforeach

        </div>

        @endif

    </div>

</div>

</x-app-layout>