<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('seller_profile_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['seller_profile_id']);
            $table->dropColumn('seller_profile_id');
        });
    }
};
