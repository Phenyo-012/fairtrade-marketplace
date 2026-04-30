<nav x-data="{ open: false }" class="bg-white border-b border-gray-300">

    @php
        $cartCount = auth()->check()
            ? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity')
            : 0;
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- TOP ROW -->
        <div class="flex items-center justify-between h-14 sm:h-20">

            <!-- LEFT SIDE -->
            <div class="flex items-center gap-4">

                <!-- LOGO -->
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/fairTrade-logo2.png') }}"
                        alt="FairTrade Logo"
                        class="block h-10 sm:h-12 md:h-16 w-auto mt-2 mb-2" />
                </a>

                <!-- CATEGORY BURGER DESKTOP ONLY -->
                <div class=" sm:block">
                    <x-category-menu />
                </div>

            </div>

            <!-- DESKTOP SEARCH -->
            <div class="hidden sm:flex flex-1 justify-center rounded-2xl">
                <form action="{{ route('marketplace.index') }}" method="GET" class="w-full max-w-xl">
                    <input type="text" name="search"
                        placeholder="Search for anything..."
                        class="w-full border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-300 rounded-3xl">
                </form>
            </div>

            <!-- DESKTOP RIGHT SIDE -->
            <div class="hidden sm:flex items-center gap-4">

               <a href="{{ route('wishlist.index') }}" :active="request()->routeIs('wishlist.*')" title="Wishlist">
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
                <a href="{{ route('support.contact') }}" title="Contact Support" class="text-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="#060606" stroke-dasharray="62" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 3c0.5 0 2.5
                             4.5 2.5 5c0 1 -1.5 2 -2 3c-0.5 1 0.5 2 1.5 3c0.39 0.39 2 2 3 1.5c1 -0.5 2 -2 3 -2c0.5 0 5 2 5 2.5c0 2 -1.5 3.5 -3 4c-1.5 0.5 -2.5 0.5 
                             -4.5 0c-2 -0.5 -3.5 -1 -6 -3.5c-2.5 -2.5 -3 -4 -3.5 -6c-0.5 -2 -0.5 -3 0 -4.5c0.5 -1.5 2 -3 4 -3Z">
                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="62;0"/>
                        </path>
                    </svg>
                </a>

                <!-- CART ICON -->
                <a href="{{ route('cart.index') }}" title="Shopping cart" class="relative text-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <defs>
                            <clipPath id="wipe">
                            <rect x="0" y="24" width="24" height="0">
                                <animate attributeName="y" from="24" to="0" dur="0.6s" begin="1s" fill="freeze"/>
                                <animate attributeName="height" from="0" to="24" dur="0.6s" begin="1s" fill="freeze"/>
                            </rect>
                            </clipPath>
                        </defs>

                        <!-- Fill -->
                        <path
                            d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 
                            2.25 0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75m4.431 3.122l.982 
                            6.982a.75.75 0 0 0 .743.646h9.361a.75.75 0 0 0 .688-.45l2.667-6.13a.75.75 0 0 0-.687-1.048z"
                            fill="currentColor" clip-path="url(#wipe)"/>

                        <!-- Stroke -->
                        <path
                            d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 2.25 
                            0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75"
                            fill="none" stroke="currentColor" stroke-width="1" stroke-dasharray="200" stroke-dashoffset="200">
                            <animate attributeName="stroke-dashoffset" values="200;0" dur="1s" fill="freeze"/>
                        </path>

                        <!-- Wheels -->
                        <path d="M6.034 19.5a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0" fill="currentColor">
                            <animateTransform attributeName="transform" type="scale" values="0;1.2;1" dur="0.4s" begin="1.2s" fill="freeze" additive="sum"
                            transform-origin="7.784 21.25"/>
                        </path>
                        <path d="M16.32 17.75a1.75 1.75 0 1 0 0 3.5a1.75 1.75 0 0 0 0-3.5" fill="currentColor">
                            <animateTransform attributeName="transform" type="scale" values="0;1.2;1" dur="0.4s" begin="1.3s" fill="freeze" additive="sum" 
                            transform-origin="18.07 19.5"/>
                        </path>
                    </svg>

                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs rounded-full px-1.5">
                            {{ $cartCount }}
                        </span>
                    @endif

                </a>

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

                                <x-dropdown-link :href="route('chat.index')">
                                    Messages
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

                                @if(Auth::user()->sellerProfile && Auth::user()->sellerProfile->verification_status === 'approved')
                                    <x-dropdown-link :href="route('store.show', Auth::user()->sellerProfile->id)">
                                        My Store
                                    </x-dropdown-link>
                                @endif

                                <x-dropdown-link :href="route('orders.my')">
                                    My Orders
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('chat.index')">
                                    Messages
                                </x-dropdown-link>

                                @if(Auth::user()->sellerProfile && Auth::user()->sellerProfile->onboarding_step < 3)
                                    <x-dropdown-link :href="route('seller.onboarding')" class="text-yellow-600 font-semibold">
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

                                <x-dropdown-link :href="route('admin.sellers.index')">
                                    Seller Applications
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.orders.index')">
                                    View All Seller Orders
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.chats.index')">
                                    Chat Moderation
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.support.index')">
                                    Support Tickets
                                </x-dropdown-link>

                                @if(Auth::user()->is_super_admin)
                                    <x-dropdown-link :href="route('admin.create')">
                                        Create Admin User
                                    </x-dropdown-link>
                                @endif
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

            <!-- MOBILE RIGHT ICONS -->
            <div class="flex items-center gap-4 sm:hidden">

                <!-- WISHLIST -->
                <a href="{{ route('wishlist.index') }}" title="Wishlist">
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
                <a href="{{ route('support.contact') }}" title="Contact Support" class="text-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="#060606" stroke-dasharray="62" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 3c0.5 0 2.5
                             4.5 2.5 5c0 1 -1.5 2 -2 3c-0.5 1 0.5 2 1.5 3c0.39 0.39 2 2 3 1.5c1 -0.5 2 -2 3 -2c0.5 0 5 2 5 2.5c0 2 -1.5 3.5 -3 4c-1.5 0.5 -2.5 0.5 
                             -4.5 0c-2 -0.5 -3.5 -1 -6 -3.5c-2.5 -2.5 -3 -4 -3.5 -6c-0.5 -2 -0.5 -3 0 -4.5c0.5 -1.5 2 -3 4 -3Z">
                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="1.11s" values="62;0"/>
                        </path>
                    </svg>
                </a>

                <!-- PROFILE ICON -->
                <button @click="open = !open" title="Account"
                    class="w-8 h-8 rounded-full border-gray-400 flex items-center justify-center">
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

                <!-- CART -->
                <a href="{{ route('cart.index') }}" title="Cart" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <defs>
                            <clipPath id="wipe">
                            <rect x="0" y="24" width="24" height="0">
                                <animate attributeName="y" from="24" to="0" dur="0.6s" begin="1s" fill="freeze"/>
                                <animate attributeName="height" from="0" to="24" dur="0.6s" begin="1s" fill="freeze"/>
                            </rect>
                            </clipPath>
                        </defs>

                        <!-- Fill -->
                        <path
                            d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 
                            2.25 0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75m4.431 3.122l.982 
                            6.982a.75.75 0 0 0 .743.646h9.361a.75.75 0 0 0 .688-.45l2.667-6.13a.75.75 0 0 0-.687-1.048z"
                            fill="currentColor" clip-path="url(#wipe)"/>

                        <!-- Stroke -->
                        <path
                            d="M1.566 4a.75.75 0 0 1 .75-.75h1.181a2.25 2.25 0 0 1 2.228 1.937l.061.435h13.965a2.25 2.25 0 0 1 2.063 3.148l-2.668 6.128a2.25 2.25 
                            0 0 1-2.063 1.352H7.722a2.25 2.25 0 0 1-2.228-1.937L4.24 5.396a.75.75 0 0 0-.743-.646h-1.18a.75.75 0 0 1-.75-.75"
                            fill="none" stroke="currentColor" stroke-width="1" stroke-dasharray="200" stroke-dashoffset="200">
                            <animate attributeName="stroke-dashoffset" values="200;0" dur="1s" fill="freeze"/>
                        </path>

                        <!-- Wheels -->
                        <path d="M6.034 19.5a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0" fill="currentColor">
                            <animateTransform attributeName="transform" type="scale" values="0;1.2;1" dur="0.4s" begin="1.2s" fill="freeze" additive="sum"
                            transform-origin="7.784 21.25"/>
                        </path>
                        <path d="M16.32 17.75a1.75 1.75 0 1 0 0 3.5a1.75 1.75 0 0 0 0-3.5" fill="currentColor">
                            <animateTransform attributeName="transform" type="scale" values="0;1.2;1" dur="0.4s" begin="1.3s" fill="freeze" additive="sum" 
                            transform-origin="18.07 19.5"/>
                        </path>
                    </svg>

                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs rounded-full px-1.5">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

            </div>

        </div>

        <!-- MOBILE SEARCH BAR -->
        <div class="sm:hidden pb-3">
            <form action="{{ route('marketplace.index') }}" method="GET">
                <div class="relative">
                    <input type="text"
                        name="search"
                        placeholder="Search"
                        class="w-full border px-6 py-3 focus:outline-none focus:ring-2 focus:ring-gray-300 rounded-3xl">

                    <button type="submit"
                        class="absolute border bg-blue-200 right-2 top-1/2 -translate-y-1/2 text-black rounded-full w-10 h-10 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M10 2a8 8 0 0 1 6.32 12.9l4.39 4.39l-1.42 1.42l-4.39-4.39A8 8 0 1 1 10 2m0 2a6 6 0 1 0 0 12a6 6 0 0 0 0-12"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

    </div>

    <!-- MOBILE PROFILE MENU -->
    <div x-show="open"
        x-transition
        @click.outside="open = false"
        class="sm:hidden border-t bg-white shadow-lg"
        style="display: none;">

        <div class="px-4 py-4">

            @auth
                <div class="mb-4">
                    <p class="font-bold text-gray-900">
                        Hi, {{ Auth::user()->first_name ?? Auth::user()->name ?? 'User' }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Manage your account and activity
                    </p>
                </div>

                <div class="divide-y rounded-xl border overflow-hidden">

                    <a href="{{ route('profile.edit') }}"
                        class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                        <span>Profile</span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                </path>
                            </svg>
                        </span>
                    </a>

                    <a href="{{ route('orders.my') }}"
                        class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                        <span>My Orders</span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                </path>
                            </svg>
                        </span>
                    </a>

                    <a href="{{ route('chat.index') }}"
                        class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                        <span>Messages</span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                    <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                </path>
                            </svg>
                        </span>
                    </a>

                    @if(Auth::user()->hasRole('buyer') && !Auth::user()->sellerProfile)
                        <a href="{{ route('buyer.dashboard') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>Buyer Dashboard</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('seller.setup') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>Sell on FairTrade</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>
                    @endif

                    @if(Auth::user()->hasRole('seller'))
                        <a href="{{ route('seller.dashboard') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>Seller Dashboard</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('seller.products.index') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>My Products</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('seller.orders.index') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>Order Management</span>
                           <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('seller.disputes.index') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>Disputes</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>

                        @if(Auth::user()->sellerProfile && Auth::user()->sellerProfile->verification_status === 'approved')
                            <a href="{{ route('store.show', Auth::user()->sellerProfile->id) }}"
                                class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                                <span>My Store</span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                        </path>
                                    </svg>
                                </span>
                            </a>
                        @endif
                    @endif

                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>Admin Dashboard</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('admin.disputes') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>Disputes</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('admin.products') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>Products</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('admin.reviews') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>Reviews</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('admin.sellers.index') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>Seller Applications</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('admin.orders.index') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>Seller Orders</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('admin.chats.index') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>Chat Moderation</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>

                        <a href="{{ route('admin.support.index') }}"
                            class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                            <span>Support Tickets</span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                        <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                    </path>
                                </svg>
                            </span>
                        </a>

                        @if(Auth::user()->is_super_admin)
                            <a href="{{ route('admin.create') }}"
                                class="flex justify-between items-center px-4 py-4 hover:bg-gray-50">
                                <span>Create Admin User</span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path fill="none" stroke="currentColor" stroke-dasharray="10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l-5 -5M15 12l-5 5">
                                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="1s" values="10;0" />
                                        </path>
                                    </svg>
                                </span>
                            </a>
                        @endif
                    @endif

                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button class="w-full bg-black text-white py-3 rounded-full font-semibold">
                        Log Out
                    </button>
                </form>
            @endauth

            @guest
                <div class="mb-4">
                    <p class="font-bold text-gray-900">Welcome to FairTrade</p>
                    <p class="text-sm text-gray-500">Sign in or create an account to continue.</p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('login') }}"
                        class="border border-black rounded-full py-3 text-center font-semibold">
                        Sign In
                    </a>

                    <a href="{{ route('register') }}"
                        class="bg-black text-white rounded-full py-3 text-center font-semibold">
                        Register
                    </a>
                </div>
            @endguest

        </div>

    </div>

</nav>