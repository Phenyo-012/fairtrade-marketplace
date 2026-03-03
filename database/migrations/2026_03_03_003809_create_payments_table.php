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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('payment_method', [
                'payfast',
                'ozow',
                'eft',
                'cash_on_delivery'
            ]);

            $table->enum('payment_status', [
                'pending',
                'held_in_escrow',
                'released',
                'refunded',
                'failed'
            ])->default('pending');

            $table->decimal('amount', 10, 2);

            $table->timestamp('released_at')->nullable();
            $table->timestamp('refunded_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
