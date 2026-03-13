<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_photo_path')->nullable();
            $table->string('theme')->default('light');
            $table->string('status')->default('active');
            $table->json('created_by')->nullable();
            $table->rememberToken();
            
            // 2FA and Login Verification
            $table->boolean('two_factor_enabled')->default(false);
            $table->string('two_factor_secret')->nullable();
            $table->string('two_factor_backup_codes')->nullable();
            $table->string('login_verification_code')->nullable();
            $table->dateTime('login_verification_code_expires_at')->nullable();
            $table->integer('login_attempts')->default(0);
            $table->dateTime('last_login_attempt_at')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('name');
            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
