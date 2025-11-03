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
        Schema::table('videos', function (Blueprint $table) {
            // This line adds the 'video_type' column after the 'thumbnail_url' column
            $table->string('video_type')->default('youtube')->after('thumbnail_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            // This line correctly removes the column if we ever need to roll back
            $table->dropColumn('video_type');
        });
    }
};