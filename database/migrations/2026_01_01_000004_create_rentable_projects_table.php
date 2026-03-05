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
            $table->string('type'); // shipping, website_builder, etc.
            $table->string('api_url');
            $table->string('api_key')->nullable();
            $table->decimal('pricing_24h', 10, 2)->default(0);
            $table->decimal('pricing_7d', 10, 2)->default(0);
            $table->decimal('pricing_30d', 10, 2)->default(0);
            $table->decimal('pricing_365d', 10, 2)->default(0);
            $table->integer('sort_order')->default(0);
            $table->json('details')->nullable(); // Flexible JSON for features, specs, config, etc.
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('slug');
            $table->index('type');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentable_projects');
    }
};
