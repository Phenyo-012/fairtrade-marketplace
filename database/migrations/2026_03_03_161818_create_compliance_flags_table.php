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
        Schema::create('compliance_flags', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('flag_type', [
                'late_shipment',
                'failed_shipment',
                'policy_violation',
                'fraud_suspicion',
                'other'
            ]);

            $table->unsignedTinyInteger('strike_level'); 
            // 1 = warning, 2 = suspension, 3 = permanent review

            $table->text('notes')->nullable();

            $table->foreignId('issued_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compliance_flags');
    }
};
