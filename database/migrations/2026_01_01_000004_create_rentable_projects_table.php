<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentable_projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->uuid('category_id')->nullable();
            $table->uuid('subcategory_id')->nullable();
            $table->string('api_url');
            $table->string('api_key')->nullable()->unique();
            $table->string('api_secret')->nullable();
            $table->decimal('pricing_24h', 10, 2)->default(0);
            $table->decimal('pricing_7d', 10, 2)->default(0);
            $table->decimal('pricing_30d', 10, 2)->default(0);
            $table->decimal('pricing_365d', 10, 2)->default(0);
            $table->integer('sort_order')->default(0);
            $table->string('banner_image')->nullable();
            $table->json('media_images')->nullable();
            $table->boolean('is_buyable')->default(false);
            $table->boolean('is_rentable')->default(false);
            $table->json('details')->nullable(); // Flexible JSON for features, specs, config, etc.
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('set null');
            $table->index('slug');
            $table->index('category_id');
            $table->index('subcategory_id');
            $table->index('status');
            $table->index('is_buyable');
            $table->index('is_rentable');
            $table->index('api_key');
            $table->index('api_secret');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentable_projects');
    }
};
