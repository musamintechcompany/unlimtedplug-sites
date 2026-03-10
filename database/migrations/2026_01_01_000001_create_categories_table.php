<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('tag')->nullable(); // SEO meta keywords
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('created_by_type')->nullable(); // 'admin' or 'user'
            $table->uuid('created_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('slug');
            $table->index('is_active');
            $table->index('sort_order');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
