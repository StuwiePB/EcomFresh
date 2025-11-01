<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_stores', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Hua Ho, Soon Lee, Supa Save
            $table->string('slug')->unique();
            $table->string('location');
            $table->string('store_hours')->default('8AM-9PM');
            $table->decimal('rating', 2, 1)->default(4.0); // 4.5, 3.8, etc.
            $table->string('contact_number')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_stores');
    }
};