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
        Schema::table('seller_profiles', function (Blueprint $table) {
            //
            Schema::table('seller_profiles', function (Blueprint $table) {
                $table->string('pickup_address')->nullable();
                $table->string('pickup_city')->nullable();
                $table->string('pickup_postal_code')->nullable();
                $table->string('pickup_country')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            //
            Schema::table('seller_profiles', function (Blueprint $table) {
                $table->dropColumn('pickup_address');
                $table->dropColumn('pickup_city');
                $table->dropColumn('pickup_postal_code');
                $table->dropColumn('pickup_country');
            });
        });
    }
};
