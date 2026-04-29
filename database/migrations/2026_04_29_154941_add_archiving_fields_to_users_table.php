<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_archived')->default(false)->after('password');
            $table->timestamp('archived_at')->nullable()->after('is_archived');

            $table->string('archived_email')->nullable()->after('archived_at');
            $table->string('archived_phone')->nullable()->after('archived_email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_archived',
                'archived_at',
                'archived_email',
                'archived_phone',
            ]);
        });
    }
};
