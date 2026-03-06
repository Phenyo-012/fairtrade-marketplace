<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Buyer (user placing the order)
            $table->foreignId('buyer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Seller (owner of the products in this order)
            $table->foreignId('seller_profile_id')
                ->constrained()
                ->cascadeOnDelete();

            // Product being ordered
            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('quantity');

            $table->decimal('total_amount', 10, 2);

            $table->enum('status', [
                'pending',
                'awaiting_shipment',
                'shipped',
                'delivered',
                'disputed',
                'completed',
                'cancelled'
            ])->default('pending');

            // Unique delivery confirmation code
            $table->string('delivery_code')->unique();

            $table->date('seller_deadline')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
