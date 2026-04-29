<div x-data="{ 
        open: false,
        active: null,
        categories: @js(config('categories'))
    }"
    class="relative">

    <!-- BURGER BUTTON -->
    <button @click="open = true"
        class="text-xl px-3 py-2 hover:bg-gray-100 rounded-xl">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
            viewBox="0 0 24 24">
            <g fill="none" stroke="#000" stroke-linecap="round" 
                stroke-linejoin="round" stroke-width="1">
                <g stroke-dasharray="28">
                    <path d="M9.5 5c0 -0.83 0.67 -1.5 1.5 -1.5h8c0.83 
                        0 1.5 0.67 1.5 1.5c0 0.83 -0.67 1.5 -1.5 1.5h-8c-0.83 
                        0 -1.5 -0.67 -1.5 -1.5Z">
                        <animate fill="freeze" attributeName="stroke-dashoffset" 
                        dur="0.74s" values="28;0"/>
                    </path>
                    <path stroke-dashoffset="28" d="M9.5 12c0 -0.83 0.67 -1.5 1.5 
                        -1.5h8c0.83 0 1.5 0.67 1.5 1.5c0 0.83 -0.67 1.5 -1.5 1.5h-8c-0.83 
                        0 -1.5 -0.67 -1.5 -1.5Z">
                        <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.925s" 
                        dur="0.74s" to="0"/>
                    </path>
                    <path stroke-dashoffset="28" d="M9.5 19c0 -0.83 0.67 -1.5 1.5 -1.5h8c0.83 0 
                        1.5 0.67 1.5 1.5c0 0.83 -0.67 1.5 -1.5 1.5h-8c-0.83 0 -1.5 -0.67 -1.5 -1.5Z">
                        <animate fill="freeze" attributeName="stroke-dashoffset" begin="1.85s" dur="0.74s" 
                        to="0"/>
                    </path>
                </g>
                <g stroke-dasharray="12" stroke-dashoffset="12">
                    <path d="M3.5 5c0 -0.83 0.67 -1.5 1.5 -1.5c0.83 0 1.5 0.67 1.5 1.5c0 0.83 -0.67 1.5 -1.5 
                        1.5c-0.83 0 -1.5 -0.67 -1.5 -1.5Z">
                        <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.555s" dur="0.37s" to="0"/>
                    </path>
                    <path d="M3.5 12c0 -0.83 0.67 -1.5 1.5 -1.5c0.83 0 1.5 0.67 1.5 1.5c0 0.83 -0.67 1.5 -1.5 1.5c-0.83 
                        0 -1.5 -0.67 -1.5 -1.5Z">
                        <animate fill="freeze" attributeName="stroke-dashoffset" begin="1.48s" dur="0.37s" to="0"/>
                    </path>
                    <path d="M3.5 19c0 -0.83 0.67 -1.5 1.5 -1.5c0.83 0 1.5 0.67 1.5 1.5c0 0.83 -0.67 1.5 -1.5 1.5c-0.83 0 
                        -1.5 -0.67 -1.5 -1.5Z">
                        <animate fill="freeze" attributeName="stroke-dashoffset" begin="2.405s" dur="0.37s" to="0"/>
                    </path>
                </g>
            </g>
        </svg> 
    </button>

    <!-- OVERLAY -->
    <div x-show="open"
        x-transition.opacity
        @click="open = false"
        class="fixed inset-0 bg-black/40 z-40"
        style="display: none;">
    </div>

    <!-- SIDE DRAWER -->
    <aside x-show="open"
        x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed top-0 left-0 z-50 h-screen w-screen max-w-[760px] bg-white shadow-2xl border-r rounded-3xl border-black/10 flex"
        style="display: none;">

        <!-- LEFT SIDE: MAIN CATEGORIES -->
        <div class="w-1/2 bg-gray-50 border-r h-full overflow-y-auto">

            <!-- HEADER -->
            <div class="sticky top-0 bg-gray-50 z-10 p-4 border-b flex items-center justify-between">
                <h2 class="font-bold text-lg">Categories</h2>

                <button @click="open = false"
                    class="text-2xl leading-none hover:text-red-500">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                        viewBox="0 0 24 24">
                        <path fill="none" stroke="#ff0505" stroke-linecap="round" 
                            stroke-linejoin="round" stroke-width="2" d="M5 5l7 7l7 
                            -7M12 12h0M5 19l7 -7l7 7">
                                <animate fill="freeze" attributeName="d" dur="0.1s" 
                                    values="M5 5l7 0l7 0M5 12h14M5 19l7 0l7 0;M5 5l7 7l7 
                                    -7M12 12h0M5 19l7 -7l7 7"/>
                        </path>
                    </svg>
                </button>
            </div>

            <template x-for="(subs, main) in categories" :key="main">
                <div
                    @mouseenter="active = main"
                    @click="active = main"
                    class="p-4 rounded-xl cursor-pointer hover:bg-white flex justify-between items-center border-b transition"
                    :class="active === main ? 'bg-white font-semibold' : ''">

                    <span x-text="main"></span>

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                        </path>
                    </svg>
                </div>
            </template>

        </div>

        <!-- RIGHT SIDE: SUBCATEGORIES -->
        <div class="w-1/2 p-6 h-full overflow-y-auto">

            <template x-if="!active">
                <div class="h-full flex items-center justify-center text-gray-400 text-sm">
                    Select a category to view subcategories
                </div>
            </template>

            <template x-if="active">
                <div>
                    <div class="mb-5">
                        <h3 class="text-2xl font-bold text-gray-800"
                            x-text="active"></h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Choose a subcategory to browse products
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

                        <template x-for="sub in categories[active]" :key="sub">
                            <a :href="`/marketplace?category=${encodeURIComponent(sub)}`"
                                @click="open = false"
                                class="block p-4 border rounded-xl hover:shadow-md hover:bg-gray-100 transition">

                                <span x-text="sub"></span>

                            </a>
                        </template>

                    </div>
                </div>
            </template>

        </div>

    </aside>
</div>