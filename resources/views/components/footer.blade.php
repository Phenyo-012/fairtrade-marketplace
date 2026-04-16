<footer class="bg-white text-black border-t border-gray-300  mt-16 rounded-t-xl">

    <div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-4 gap-8">

        <!-- BRAND -->
        <div>
            <!-- WEBSITE LOGO -->
            <div class="flex items-center justify-center mb-4">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-black mb-4 inline-block">
                    <img src="{{ asset('images/fairTrade-logo2.png') }}"
                        alt="FairTrade Logo"
                        class="h-20 w-auto inline-block mr-2">
                </a>
            </div>

            <div>
                <p class="text-sm text-gray-400">
                    A trusted marketplace connecting buyers and sellers nationwide.
                </p>
            </div>
        </div>

        <!-- NAVIGATION -->
        <div>
            <h4 class="text-black font-semibold mb-3">Marketplace</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="/" class="text-gray-500 hover:text-gray-700">Home</a></li>
                <li><a href="/marketplace" class="text-gray-500 hover:text-gray-700">Browse Products</a></li>
                <li><a href="/cart" class="text-gray-500 hover:text-gray-700">Cart</a></li>
            </ul>
        </div>

        <!-- SELLERS -->
        <div>
            <h4 class="text-black font-semibold mb-3">For Sellers</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="/become-seller" class="text-gray-500 hover:text-gray-700">Become a Seller</a></li>
                <li><a href="/seller/dashboard" class="text-gray-500 hover:text-gray-700">Seller Dashboard</a></li>
                <li><a href="/seller/orders" class="text-gray-500 hover:text-gray-700">Manage Orders</a></li>
            </ul>
        </div>

        <!-- LEGAL -->
        <div>
            <h4 class="text-black font-semibold mb-3">Legal</h4>
            <ul class="space-y-2 text-sm">
                <li>
                    <a href="{{ route('terms') }}" class="text-gray-500 hover:text-gray-700">
                        Terms of Service
                    </a>
                </li>
                <li>
                    <a href="{{ route('privacy') }}" class="text-gray-500 hover:text-gray-700">
                        Privacy Policy
                    </a>
                </li>
                <li>
                    <a href="{{ route('refund') }}" class="text-gray-500 hover:text-gray-700">Refund Policy
                        
                    </a>
                </li>
            </ul>
        </div>

    </div>

    <!-- BOTTOM -->
    <div class="border-t border-gray-300 text-center text-sm py-4 text-gray-500">
        © {{ date('Y') }} FairTrade. All rights reserved.
    </div>

</footer>