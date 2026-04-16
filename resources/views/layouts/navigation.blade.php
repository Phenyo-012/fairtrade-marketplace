<nav x-data="{ open: false }" class="bg-white border-b border-gray-300">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
        <div class="flex items-center justify-between h-20">

            <!-- LEFT SIDE -->
            <div class="flex items-center gap-4">
    
                <!-- LOGO -->
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/fairTrade-logo2.png') }}"
                        alt="FairTrade Logo" 
                        class="block h-20 w-auto fill-current text-gray-800 mt-4 mb-4" />
                </a>

                <!-- CATEGORY BURGER -->
                <x-category-menu />

            </div>

            <!-- CENTER SEARCH -->
            <div class="hidden sm:flex flex-1 justify-center rounded-2xl">
                <form action="{{ route('marketplace.index') }}" method="GET" class="w-full max-w-xl">
                    <input type="text" name="search"
                        placeholder="Search for anything..."
                        class="w-full border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-300 rounded-2xl">
                </form>
            </div>

            <!-- RIGHT SIDE -->
            <div class="hidden sm:flex items-center gap-4">

                <a href="{{ route('wishlist.index') }}" :active="request()->routeIs('wishlist.*')">
                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-dasharray="30" stroke-linecap="round" 
                            stroke-linejoin="round" stroke-width="2" d="M12 8c0 0 0 0 -0.76 -1c-0.88 -1.16 
                            -2.18 -2 -3.74 -2c-2.49 0 -4.5 2.01 -4.5 4.5c0 0.93 0.28 1.79 0.76 2.5c0.81 1.21 
                            8.24 9 8.24 9M12 8c0 0 0 0 0.76 -1c0.88 -1.16 2.18 -2 3.74 -2c2.49 0 4.5 2.01 4.5 
                            4.5c0 0.93 -0.28 1.79 -0.76 2.5c-0.81 1.21 -8.24 9 -8.24 9">
                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="30;0"/>
                        </path>
                    </svg>
                </a>
                <!-- SUPPORT ICON -->
                <a href="#" class="text-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="#060606" stroke-dasharray="62" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 3c0.5 0 2.5
                             4.5 2.5 5c0 1 -1.5 2 -2 3c-0.5 1 0.5 2 1.5 3c0.39 0.39 2 2 3 1.5c1 -0.5 2 -2 3 -2c0.5 0 5 2 5 2.5c0 2 -1.5 3.5 -3 4c-1.5 0.5 -2.5 0.5 
                             -4.5 0c-2 -0.5 -3.5 -1 -6 -3.5c-2.5 -2.5 -3 -4 -3.5 -6c-0.5 -2 -0.5 -3 0 -4.5c0.5 -1.5 2 -3 4 -3Z">
                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="62;0"/>
                        </path>
                    </svg>
                </a>

                <!-- CART ICON -->
                <a href="{{ route('cart.index') }}" class="relative text-xl">
                   <svg xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24">

                        <path
                            fill="currentColor"
                            fill-opacity="0"
                            stroke="currentColor"
                            stroke-width="0.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-dasharray="230"
                            stroke-dashoffset="230"
                            d="M2.316 3.25a.75.75 0 1 0 0 1.5h1.181a.75.75 0 0 1 .743.646l1.254 8.917a2.25 2.25 0 0 0 2.228 1.937h10.344a.75.75 
                            0 0 0 0-1.5H7.722a.75.75 0 0 1-.743-.646l-.12-.853h10.852a2.25 2.25 0 0 0 2.15-1.583l1.921-6.188a.75.75 0 0 0-.716-.972H5.516A2.25 2.25 0 
                            0 0 3.498 3.25zm3.525 2.758h14.207l-1.62 5.215a.75.75 0 0 1-.717.527H6.648zM7.784 17.75a1.75 1.75 0 1 0 0 3.5a1.75 1.75 0 0 0 0-3.5m6.786 
                            1.75a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0">

                            <animate attributeName="stroke-dashoffset"
                                    values="260;0"
                                    dur="1.1s"
                                    fill="freeze"/>

                            <animate attributeName="fill-opacity"
                                    begin="1.1s"
                                    dur="0.6s"
                                    to="1"
                                    fill="freeze"/>
                        </path>
                    </svg>
                    @php
                        $cartCount = auth()->check()
                            ? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity')
                            : 0;
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-2">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- USER DROPDOWN -->
                @auth
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white hover:text-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" stroke="#060606" stroke-dasharray="28" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M4 21v-1c0 -3.31 2.69 -6 6 -6h4c3.31 0 6 2.69 6 6v1">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.74s" values="28;0"/>
                                    </path>
                                    <path stroke-dashoffset="28" d="M12 11c-2.21 0 -4 -1.79 -4 -4c0 -2.21 1.79 -4 4 -4c2.21 0 4 1.79 4 4c0 2.21 -1.79 4 -4 4Z">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.74s" dur="0.74s" to="0"/>
                                    </path>
                                </g>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <hr>

                        @if(Auth::user()->hasRole('buyer') && !Auth::user()->sellerProfile)
                            <x-dropdown-link :href="route('buyer.dashboard')">
                                Buyer Dashboard
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('orders.my')">
                                My Orders
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('seller.setup')">
                                Sell on FairTrade
                            </x-dropdown-link>
                        @endif

                        @if(Auth::user()->hasRole('seller'))
                            <x-dropdown-link :href="route('seller.dashboard')">
                                Seller Dashboard
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('seller.products.index')">
                                My Products
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('seller.orders.index')">
                                Order Management
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('seller.disputes.index')">
                                Disputes
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('store.show', Auth::user()->sellerProfile->id)">
                                My Store
                            </x-dropdown-link>

                            <!-- MY ORDERS -->
                            <x-dropdown-link :href="route('orders.my')">
                                My Orders
                            </x-dropdown-link>

                            @if(Auth::user()->sellerProfile && Auth::user()->sellerProfile->onboarding_step < 3)
                                <x-dropdown-link :href="route('seller.onboarding')"
                                    class="text-yellow-600 font-semibold">
                                    Complete Setup
                                </x-dropdown-link>
                            @endif
                        @endif

                        @if(Auth::user()->hasRole('admin'))
                            <x-dropdown-link :href="route('admin.dashboard')">
                                Admin Dashboard
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('admin.disputes')">
                                Disputes
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('admin.products')">
                                Products
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('admin.reviews')">
                                Reviews
                            </x-dropdown-link>
                            
                            <!-- APPROVE SELLER APPLICATIONS -->
                            <x-dropdown-link :href="route('admin.sellers.index')">
                                Seller Applications
                            </x-dropdown-link>

                            <!-- GLOBAL ORDERS -->
                            <x-dropdown-link :href="route('admin.orders.index')">
                                View All Seller Orders
                            </x-dropdown-link>
                        @endif

                        <hr>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>

                    </x-slot>
                </x-dropdown>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-gray-700">Login</a>
                    <a href="{{ route('register') }}" class="bg-black text-white px-3 py-1 rounded-2xl">
                        Register
                    </a>
                @endguest

            </div>

            <!-- MOBILE HAMBURGER -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" stroke="#060606" stroke-dasharray="28" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M4 21v-1c0 -3.31 2.69 -6 6 -6h4c3.31 0 6 2.69 6 6v1">
                                  <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.74s" values="28;0"/>
                            </path>
                            <path stroke-dashoffset="28" d="M12 11c-2.21 0 -4 -1.79 -4 -4c0 -2.21 1.79 -4 4 -4c2.21 0 4 1.79 4 4c0 2.21 -1.79 4 -4 4Z">
                                 <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.74s" dur="0.74s" to="0"/>
                            </path>
                         </g>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open" class="sm:hidden px-4 pb-4">

        <form action="{{ route('marketplace.index') }}" method="GET" class="mb-3">
            <input type="text" name="search"
                placeholder="Search..."
                class="w-full border rounded-xl px-3 py-2">
        </form>

        @auth
            <a href="{{ route('profile.edit') }}" class="block py-2">Profile</a>
            <a href="{{ route('orders.my') }}" class="block py-2">My Orders</a>

            @if(Auth::user()->hasRole('seller'))
                <a href="{{ route('seller.dashboard') }}" class="block py-2">Seller Dashboard</a>
            @endif

            @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}" class="block py-2">Admin Dashboard</a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="block py-2">Logout</button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="block py-2">Login</a>
            <a href="{{ route('register') }}" class="block py-2">Register</a>
        @endguest

    </div>

</nav>