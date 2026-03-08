<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->uuid('rentable_project_id');
            
            // Rental details
            $table->string('duration_type')->default('daily');
            $table->integer('duration_value')->default(1);
            $table->decimal('credits_cost', 20, 2);
            $table->dateTime('rental_starts_at')->nullable();
            $table->dateTime('rental_expires_at')->nullable();
            $table->json('renewal_history')->nullable();
            $table->json('details_history')->nullable();
            $table->json('initial_details')->nullable();
            
            // Admin credentials from Shipping API
            $table->string('admin_id')->nullable();
            $table->string('admin_email');
            $table->string('admin_password')->nullable();
            $table->string('admin_url')->nullable();
            
            // Status (use 'expired' instead of 'on_hold' for clarity)
            $table->string('status')->default('active');
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('user_id');
            $table->index('rentable_project_id');
            $table->index('status');
            $table->index('rental_expires_at');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
