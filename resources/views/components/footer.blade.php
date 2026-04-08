<footer class="bg-white text-black border-t border-gray-300  mt-16 rounded-t-lg ">

    <div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-4 gap-8">

        <!-- BRAND -->
        <div>
            <!-- WEBSITE LOGO -->
            <div class="flex items-center justify-center mb-4">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-black mb-4 inline-block">
                    <img src="{{ asset('images/fairTrade-logo.png') }}"
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
                <li><a href="/" class="hover:text-black">Home</a></li>
                <li><a href="/marketplace" class="hover:text-black">Browse Products</a></li>
                <li><a href="/cart" class="hover:text-black">Cart</a></li>
            </ul>
        </div>

        <!-- SELLERS -->
        <div>
            <h4 class="text-black font-semibold mb-3">For Sellers</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="/become-seller" class="hover:text-black">Become a Seller</a></li>
                <li><a href="/seller/dashboard" class="hover:text-black">Seller Dashboard</a></li>
                <li><a href="/seller/orders" class="hover:text-black">Manage Orders</a></li>
            </ul>
        </div>

        <!-- LEGAL -->
        <div>
            <h4 class="text-black font-semibold mb-3">Legal</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:text-black">Terms of Service</a></li>
                <li><a href="#" class="hover:text-black">Privacy Policy</a></li>
                <li><a href="#" class="hover:text-black">Refund Policy</a></li>
            </ul>
        </div>

    </div>

    <!-- BOTTOM -->
    <div class="border-t border-gray-300 text-center text-sm py-4 text-gray-500">
        © {{ date('Y') }} FairTrade. All rights reserved.
    </div>

</footer>