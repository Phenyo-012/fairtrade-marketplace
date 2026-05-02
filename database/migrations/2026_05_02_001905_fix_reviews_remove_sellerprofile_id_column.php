<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('reviews', 'sellerProfile_id')) {
            Schema::table('reviews', function (Blueprint $table) {
                try {
                    $table->dropForeign('reviews_sellerprofile_id_foreign');
                } catch (\Throwable $e) {
                    // Foreign key may already be missing in some environments.
                }
            });

            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('sellerProfile_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('reviews', 'sellerProfile_id')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->foreignId('sellerProfile_id')
                    ->nullable()
                    ->after('buyer_id')
                    ->constrained('seller_profiles')
                    ->nullOnDelete();
            });
        }
    }
};