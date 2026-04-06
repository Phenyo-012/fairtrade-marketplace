<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- LEFT SIDE -->
            <div class="flex items-center gap-4">
    
                <!-- LOGO -->
                <a href="{{ url('/') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>

                <!-- CATEGORY BURGER -->
                <div x-data="{ openCategories: false }" class="relative">

                    <button @click="openCategories = !openCategories" 
                        class="text-2xl font-sans text-lg ">
                        ☰ Categories
                    </button>

                    <div x-show="openCategories"
                        @click.outside="openCategories = false"
                        class="absolute left-0 mt-2 w-64 bg-white shadow-lg rounded-xl p-3 z-50">

                        @foreach(config('categories') as $main => $subs)
                            <div class="mb-3">
                                <p class="font-semibold text-gray-800">{{ $main }}</p>

                                @foreach($subs as $sub)
                                    <a href="{{ route('marketplace.index', ['category' => $sub]) }}"
                                    class="block text-sm text-gray-600 hover:text-black ml-2">
                                        {{ $sub }}
                                    </a>
                                @endforeach
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>

            <!-- CENTER SEARCH -->
            <div class="hidden sm:flex flex-1 justify-center">
                <form action="{{ route('marketplace.index') }}" method="GET" class="w-full max-w-xl">
                    <input type="text" name="search"
                        placeholder="Search products..."
                        class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-300 rounded-2xl">
                </form>
            </div>

            <!-- RIGHT SIDE -->
            <div class="hidden sm:flex items-center gap-4">

                <!-- SUPPORT ICON -->
                <a href="#" class="text-xl">💬</a>

                <!-- CART ICON -->
                <a href="{{ route('cart.index') }}" class="relative text-xl">
                    🛒
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
                            {{ Auth::user()->first_name }}
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
                    <a href="{{ route('register') }}" class="bg-black text-white px-3 py-1 rounded">
                        Register
                    </a>
                @endguest

            </div>

            <!-- MOBILE HAMBURGER -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="text-gray-500">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open" class="sm:hidden px-4 pb-4">

        <form action="{{ route('marketplace.index') }}" method="GET" class="mb-3">
            <input type="text" name="search"
                placeholder="Search..."
                class="w-full border rounded px-3 py-2">
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