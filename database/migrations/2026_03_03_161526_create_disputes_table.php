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
    Schema::create('disputes', function (Blueprint $table) {
        $table->id();

        $table->foreignId('order_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('opened_by')
              ->constrained('users')
              ->cascadeOnDelete();

        $table->enum('reason', [
            'item_not_received',
            'damaged_item',
            'wrong_item',
            'other'
        ]);

        $table->enum('status', [
            'open',
            'under_review',
            'resolved',
            'rejected'
        ])->default('open');

        $table->text('resolution_notes')->nullable();

        $table->foreignId('resolved_by')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
