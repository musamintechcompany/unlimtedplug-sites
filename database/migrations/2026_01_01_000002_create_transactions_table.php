<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('transactable');
            $table->decimal('amount', 20, 2);
            $table->string('currency')->nullable();
            $table->decimal('price', 20, 2)->nullable();
            $table->string('type');
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index('type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
