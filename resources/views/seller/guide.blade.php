<x-app-layout>

<div class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4">

        <!-- HEADER -->
        <div class="bg-white p-6 rounded-xl shadow mb-6">
            <h1 class="text-2xl font-bold mb-2">Seller Guide</h1>
            <p class="text-gray-600 text-sm">
                Everything you need to understand how the marketplace works.
            </p>
        </div>

        <!-- SECTION -->
        <div class="space-y-6">

            <!-- ESCROW -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg mb-2">Escrow System</h2>
                <p class="text-gray-600 text-sm">
                    When a customer places an order, the payment is held in escrow.
                    This means the money is reserved but not yet released to you.
                </p>

                <ul class="list-disc ml-5 mt-3 text-sm text-gray-600 space-y-1">
                    <li>Money enters escrow when an order is placed</li>
                    <li>Money is released when the order is marked as completed</li>
                    <li>Cancelled or disputed orders are excluded</li>
                </ul>
            </div>

            <!-- ORDER STATUS -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg mb-2">Order Status</h2>

                <div class="space-y-2 text-sm text-gray-600">
                    <p><b>Pending:</b> Order has been placed</p>
                    <p><b>Awaiting Shipment:</b> You need to ship the item</p>
                    <p><b>Shipped:</b> Item is on the way</p>
                    <p><b>Delivered:</b> Buyer received item</p>
                    <p><b>Completed:</b> Order finalized and funds released</p>
                </div>
            </div>

            <!-- SHIPPING DEADLINES -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg mb-2">Shipping Deadlines</h2>

                <p class="text-sm text-gray-600">
                    Each order has a shipping deadline. If you miss it:
                </p>

                <ul class="list-disc ml-5 mt-3 text-sm text-gray-600 space-y-1">
                    <li>The order will be marked as late</li>
                    <li>Your performance rating may drop</li>
                    <li>Too many late shipments may affect your store visibility</li>
                </ul>
            </div>

            <!-- DISCOUNTS -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg mb-2">Discounts & Sales</h2>

                <p class="text-sm text-gray-600">
                    You can run limited-time promotions:
                </p>

                <ul class="list-disc ml-5 mt-3 text-sm text-gray-600 space-y-1">
                    <li>Set a discount percentage</li>
                    <li>Choose how many hours the discount lasts</li>
                    <li>Discount applies automatically during checkout</li>
                </ul>
            </div>

            <!-- FREE SHIPPING -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg mb-2">Free Shipping</h2>

                <p class="text-sm text-gray-600">
                    You can enable free shipping for your products.
                </p>

                <ul class="list-disc ml-5 mt-3 text-sm text-gray-600 space-y-1">
                    <li>This improves conversion rates</li>
                    <li>Displayed as a badge in the marketplace</li>
                    <li>You absorb the shipping cost</li>
                </ul>
            </div>

            <!-- RATINGS -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg mb-2">Ratings & Reviews</h2>

                <p class="text-sm text-gray-600">
                    Customers can review orders after delivery.
                </p>

                <ul class="list-disc ml-5 mt-3 text-sm text-gray-600 space-y-1">
                    <li>Ratings affect your store reputation</li>
                    <li>Higher ratings increase visibility</li>
                    <li>Top sellers get badges</li>
                </ul>
            </div>

            <!-- PERFORMANCE -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="font-bold text-lg mb-2">Performance Metrics</h2>

                <ul class="list-disc ml-5 text-sm text-gray-600 space-y-1">
                    <li>On-time shipping rate</li>
                    <li>Total completed orders</li>
                    <li>Customer satisfaction</li>
                </ul>
            </div>

            <!-- TIPS -->
            <div class="bg-blue-50 border border-blue-200 p-6 rounded-xl">
                <h2 class="font-bold text-lg mb-2 text-blue-700">Tips for Success</h2>

                <ul class="list-disc ml-5 text-sm text-blue-700 space-y-1">
                    <li>Ship orders quickly</li>
                    <li>Use clear product images</li>
                    <li>Write detailed descriptions</li>
                    <li>Offer discounts to boost sales</li>
                    <li>Maintain high ratings</li>
                </ul>
            </div>

        </div>

    </div>
</div>

</x-app-layout>