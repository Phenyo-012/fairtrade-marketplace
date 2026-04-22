@php
    $rating = $sellerRating ?? 0;
@endphp
<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-5">
        <div class="max-w-7xl mx-auto px-4">

            <!-- BACK TO SELLER STORE -->
            <a href="{{ route('store.show', $seller) }}" class="mt-6 px-4 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
                    </path>
                </svg>
            </a>
            
            <h2 class="text-2xl font-bold mb-6">
                {{ $seller->store_name ?? 'Store' }} - Reviews
            </h2>

            <div class="bg-white rounded-2xl shadow p-6">

                @forelse($reviews as $review)

                    <div class="border-b py-4">

                        <!-- VERIFIED BUYER badge -->
                        <div class="flex items-center gap-2 mb-2">
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs">
                                    Verified Buyer
                                </span>

                        </div>

                        <div class="flex justify-between items-center">
                            <p class="text-black font-semibold">
                                Rating: {{ $review->rating }} 
                            </p>
                            <p class="flex items-center gap-1 mt-1">
                                @switch($review->rating)
                                    @case (5)
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                                0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                                <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                            </path>
                                            </svg>
                                        @endfor
                                        @break
                                    @case (4)
                                        @for($i = 1; $i <= 4; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                                0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                                <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                            </path>
                                            </svg>
                                        @endfor
                                        @break
                                    @case (3)
                                        @for($i = 1; $i <= 3; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                                0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                                <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                            </path>
                                            </svg>
                                        @endfor
                                        @break
                                    @case (2)
                                        @for($i = 1; $i <= 2; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                                0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                                <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                            </path>
                                            </svg>
                                        @endfor
                                        @break
                                    @case (1)
                                        @for($i = 1; $i <= 1; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                                0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                                <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                            </path>
                                            </svg>
                                        @endfor
                                        @break
                                    @default
                                           <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-dasharray="66" 
                                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.35 5.76l6.21 
                                                0.46l-4.76 4.02l1.49 6.04l-5.29 -3.28l-5.29 3.28l1.49 -6.04l-4.76 -4.02l6.21 -0.46Z">
                                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="66;0"/>
                                                <animate fill="freeze" attributeName="fill-opacity" begin="1.11s" dur="0.74s" to="1"/>
                                            </path>
                                            </svg>
                                @endswitch
                            </p>

                            <p class="text-sm text-gray-400">
                                {{ $review->created_at->format('d M Y - H:i') }}
                            </p>
                        </div>

                        <p class="text-gray-700 mt-2">
                            <p>Seller Comment:</p>
                            <p>{{ $review->comment }}</p>
                        </p>
                        <br>
                        
                        <p class="text-sm text-gray-500 mt-1">
                            Product: {{ $review->orderItem->product->name ?? 'N/A' }}
                        </p>

                    </div>

                @empty
                    <p class="text-gray-500">No reviews yet.</p>
                @endforelse

                <div class="mt-6">
                    {{ $reviews->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>