<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            ALTER TABLE seller_profiles 
            MODIFY verification_status 
            ENUM('not_submitted','pending','approved','rejected') 
            DEFAULT 'not_submitted'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE seller_profiles 
            MODIFY verification_status 
            ENUM('not_submitted','pending','approved','rejected')
        ");
    }
};