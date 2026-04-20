<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // =========================
        // ORDER ITEMS
        // =========================
        Schema::table('order_items', function (Blueprint $table) {

            // Get FK name dynamically
            $fk = DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_NAME = 'order_items'
                AND COLUMN_NAME = 'product_id'
                AND REFERENCED_TABLE_NAME IS NOT NULL
                LIMIT 1
            ");

            if (!empty($fk)) {
                $table->dropForeign($fk[0]->CONSTRAINT_NAME);
            }

            // Make nullable first
            $table->unsignedBigInteger('product_id')->nullable()->change();

            // Re-add FK with NULL ON DELETE
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->nullOnDelete();
        });

        // =========================
        // PRODUCT IMAGES
        // =========================
        Schema::table('product_images', function (Blueprint $table) {

            $fk = DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_NAME = 'product_images'
                AND COLUMN_NAME = 'product_id'
                AND REFERENCED_TABLE_NAME IS NOT NULL
                LIMIT 1
            ");

            if (!empty($fk)) {
                $table->dropForeign($fk[0]->CONSTRAINT_NAME);
            }

            $table->unsignedBigInteger('product_id')->nullable()->change();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        // Optional rollback
    }
};