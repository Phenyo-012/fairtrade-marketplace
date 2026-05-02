<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Drop foreign keys first
        |--------------------------------------------------------------------------
        |
        | MySQL will not allow columns to be dropped while they are still used by
        | foreign key constraints.
        |
        */

        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'orders'
            AND COLUMN_NAME IN ('product_id', 'seller_profile_id')
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        Schema::table('orders', function (Blueprint $table) use ($foreignKeys) {
            foreach ($foreignKeys as $foreignKey) {
                $table->dropForeign($foreignKey->CONSTRAINT_NAME);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Drop old order columns
        |--------------------------------------------------------------------------
        |
        | These fields were moved into order_items.
        |
        */

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'product_id')) {
                $table->dropColumn('product_id');
            }

            if (Schema::hasColumn('orders', 'quantity')) {
                $table->dropColumn('quantity');
            }

            if (Schema::hasColumn('orders', 'seller_profile_id')) {
                $table->dropColumn('seller_profile_id');
            }
        });
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Restore old order columns
        |--------------------------------------------------------------------------
        |
        | These are nullable because existing orders may now rely on order_items.
        |
        */

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'product_id')) {
                $table->foreignId('product_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('orders', 'quantity')) {
                $table->integer('quantity')->default(1);
            }

            if (! Schema::hasColumn('orders', 'seller_profile_id')) {
                $table->foreignId('seller_profile_id')
                    ->nullable()
                    ->constrained('seller_profiles')
                    ->nullOnDelete();
            }
        });
    }
};