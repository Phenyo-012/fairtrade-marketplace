<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE seller_profiles
            MODIFY verification_status ENUM(
                'not_submitted',
                'pending',
                'approved',
                'rejected',
                'archived'
            ) NOT NULL DEFAULT 'not_submitted'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE seller_profiles
            MODIFY verification_status ENUM(
                'not_submitted',
                'pending',
                'approved',
                'rejected'
            ) NOT NULL DEFAULT 'not_submitted'
        ");
    }
};