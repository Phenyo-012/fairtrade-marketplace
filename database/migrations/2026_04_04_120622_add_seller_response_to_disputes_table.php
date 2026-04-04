<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::table('disputes', function (Blueprint $table) {
            $table->text('seller_response')->nullable();
            $table->timestamp('seller_responded_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('disputes', function (Blueprint $table) {
            $table->dropColumn(['seller_response', 'seller_responded_at']);
        });
    }
};
