<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Stores total time spent in seconds
            $table->unsignedBigInteger('time_spent')->default(0)->after('app_status');
            
            // Tracks user status: active, blocked, unblock_request
            $table->string('status')->default('active')->after('time_spent');
            
            // Stores the admin's note for blocking a user
            $table->text('block_note')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['time_spent', 'status', 'block_note']);
        });
    }
};