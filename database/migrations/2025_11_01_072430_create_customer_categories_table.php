<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Chicken, Beef, Vegetables
            $table->string('slug')->unique(); // chicken, beef, vegetables
            $table->text('description');
            $table->string('image');
            $table->string('icon')->default('shopping-basket');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_categories');
    }
};