@php
    $rating = $sellerRating ?? 0;
@endphp
<x-app-layout>
    <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-5xl mx-auto px-4">

            <!-- BACK LINK BUTTON -->
            <a href="{{ route('store.show', $seller) }}"
            class="inline-flex items-center gap-1 text-gray-500 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                Back to Store
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
                                            <p>
                                                error
                                            </p>
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