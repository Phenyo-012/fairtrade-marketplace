<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('courier_name')->nullable();
            $table->string('courier_service')->nullable()->after('courier_name');
            $table->string('courier_tracking_number')->nullable()->after('courier_service');
            $table->decimal('courier_fee', 10, 2)->nullable()->after('courier_tracking_number');
            $table->timestamp('courier_booked_at')->nullable()->after('courier_fee');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'courier_name',
                'courier_service',
                'courier_tracking_number',
                'courier_fee',
                'courier_booked_at',
            ]);
        });
    }
};
