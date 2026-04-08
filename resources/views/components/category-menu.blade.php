<div x-data="{
        open: false,
        active: null,
        categories: @js(config('categories'))
    }"
    class="relative">

    <!-- BURGER BUTTON -->
    <button @click="open = !open"
        class="text-xl px-3 py-2 hover:bg-gray-100 rounded">
        ☰ 
    </button>

    <!-- DROPDOWN PANEL -->
    <div x-show="open"
        x-transition
        @click.outside="open = false"
        class="absolute left-0 mt-2 w-[700px] bg-white shadow-2xl rounded-xl z-50 flex">

        <!-- LEFT SIDE: MAIN CATEGORIES -->
        <div class="w-1/3 border-r bg-gray-50">

            <template x-for="(subs, main) in categories" :key="main">
                <div
                    @mouseenter="active = main"
                    @click="active = main"
                    class="p-3 cursor-pointer hover:bg-white flex justify-between items-center">

                    <span x-text="main"></span>

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" stroke="#060606" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path stroke-dasharray="60" d="M21 12c0 4.97 -4.03 9 -9 9c-4.97 0 -9 -4.03 -9 -9c0 -4.97 4.03 -9 9 -9c4.97 0 9 4.03 9 9Z">
                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="60;0"/>
                            </path>
                            <path stroke-dasharray="8" stroke-dashoffset="8" d="M14 12l-3 -3M14 12l-3 3">
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="1.1s" dur="0.4s" to="0"/>
                            </path>
                        </g>
                    </svg>
                </div>
            </template>

        </div>

        <!-- RIGHT SIDE: SUBCATEGORIES -->
        <div class="w-2/3 p-4">

            <template x-if="active">
                <div>
                    <h3 class="font-semibold mb-3 text-gray-700"
                        x-text="active"></h3>

                    <div class="grid grid-cols-2 gap-3">

                        <template x-for="sub in categories[active]" :key="sub">
                            <a
                                :href="`/marketplace?category=${sub}`"
                                class="block p-3 border rounded-lg hover:shadow hover:bg-gray-50 transition">

                                <span x-text="sub"></span>

                            </a>
                        </template>

                    </div>
                </div>
            </template>

        </div>

    </div>
</div>