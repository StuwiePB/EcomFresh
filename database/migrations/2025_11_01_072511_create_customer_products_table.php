<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('customer_categories');
            $table->string('name'); // Chicken Breast, Whole Chicken, etc.
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image');
            $table->string('unit')->default('kg'); // kg, piece, bundle
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_products');
    }
};