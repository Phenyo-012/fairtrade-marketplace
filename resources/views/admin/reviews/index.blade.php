<x-app-layout>

<div class="max-w-6xl mx-auto py-5 px-4">

    <a href="{{ route('admin.dashboard') }}" class="mt-6 px-4 py-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-dasharray="12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l7 -7M8 12l7 7">
                <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.62s" values="12;0" />
            </path>
        </svg>
    </a>

    <h2 class="text-2xl font-bold mb-6">Review Moderation</h2>

    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold">Pending Reviews</h2>

        <a href="{{ route('admin.reviews.archive') }}"
        class="bg-gray-800 text-white px-4 py-2 rounded-3xl hover:bg-gray-700 transition">
            View Archive
        </a>

    </div>

    @foreach($reviews as $review)
        <a href="{{ route('admin.reviews.show', $review) }}">
            <div class="bg-white p-4 rounded-xl shadow mb-4 hover:shadow-md transition cursor-pointer">

                <p class="font-semibold">
                  <strong>Product:</strong>  {{ $review->orderItem->product->name }}
                </p>

                <div class="flex items-center">
                    <p class="text-black font-semibold">
                        Rating: {{ $review->rating }} 
                    </p>
                    <p class="flex">
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
                </div>

                <p class="text-sm text-gray-500 line-clamp-2">
                    {{ $review->comment }}
                </p>

                <p class="text-xs text-gray-400 mt-2">
                    Pending review
                </p>

            </div>
        </a>
    @endforeach

    {{ $reviews->links() }}

</div>

</x-app-layout>