<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {

            // REMOVE invalid column (if exists)
            if (Schema::hasColumn('reviews', 'seller_id')) {
                $table->dropColumn('seller_id');
            }

            // ADD correct relation
            if (!Schema::hasColumn('reviews', 'order_item_id')) {
                $table->foreignId('order_item_id')
                      ->after('order_id')
                      ->constrained()
                      ->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {

            if (Schema::hasColumn('reviews', 'order_item_id')) {
                $table->dropForeign(['order_item_id']);
                $table->dropColumn('order_item_id');
            }

            $table->unsignedBigInteger('seller_id')->nullable();
        });
    }
};