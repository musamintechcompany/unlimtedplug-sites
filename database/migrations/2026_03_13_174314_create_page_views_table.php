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
        Schema::create('page_views', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('visitor_id');
            $table->string('url');
            $table->string('page_type')->nullable(); // project, category, cart, checkout, etc.
            $table->uuid('page_id')->nullable(); // ID of project, category, etc.
            $table->string('action')->nullable(); // view, rent, buy, search, etc.
            $table->json('metadata')->nullable(); // Extra data (search query, project name, etc.)
            $table->integer('time_spent')->nullable(); // Seconds spent on page
            $table->timestamps();
            
            $table->foreign('visitor_id')->references('id')->on('visitors')->onDelete('cascade');
            $table->index('visitor_id');
            $table->index('page_type');
            $table->index('page_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
