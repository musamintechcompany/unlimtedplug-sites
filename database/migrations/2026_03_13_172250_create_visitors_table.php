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
        Schema::create('visitors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('visitor_id')->unique(); // Unique fingerprint (IP + User Agent hash)
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('device_type')->nullable(); // mobile, desktop, tablet
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('referrer')->nullable();
            $table->uuid('user_id')->nullable(); // If they register, link to user
            $table->json('data')->nullable(); // Flexible JSON for pages visited, timestamps, etc
            $table->timestamp('first_visit')->nullable();
            $table->timestamp('last_visit')->nullable();
            $table->timestamps();
            
            $table->index('visitor_id');
            $table->index('user_id');
            $table->index('country');
            $table->index('last_visit');
            $table->index('created_at');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
