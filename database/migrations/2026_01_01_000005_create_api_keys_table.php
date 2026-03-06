<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('keyable');
            $table->string('name');
            $table->string('key')->unique();
            $table->integer('requests_count')->default(0);
            $table->timestamp('last_used_at')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('key');
            $table->index('status');
            $table->index('last_used_at');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};
