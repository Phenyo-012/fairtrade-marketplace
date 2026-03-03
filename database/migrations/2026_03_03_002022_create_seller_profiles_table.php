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
        Schema::create('seller_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('store_name')->unique();
            $table->text('store_description')->nullable();

            $table->boolean('identity_verified')->default(false);

            $table->enum('verification_status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            $table->integer('total_sales_count')->default(0);
            $table->decimal('successful_delivery_rate', 5, 2)->default(0.00);

            $table->decimal('commission_rate', 5, 2)->default(5.00);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_profiles');
    }
};
