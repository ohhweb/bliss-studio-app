<?php
// In the new create_watched_histories_table migration file
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('watched_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // `updated_at` will be our "last watched" time
            $table->unique(['user_id', 'video_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('watched_histories');
    }
};