<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('device_identifier')->unique(); // Our custom-generated unique ID
            $table->string('user_agent', 512);
            $table->string('ip_address', 45)->nullable();
            $table->string('location')->nullable();
            $table->string('battery_level')->nullable();
            $table->string('network_type')->nullable();
            $table->timestamp('last_seen_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};