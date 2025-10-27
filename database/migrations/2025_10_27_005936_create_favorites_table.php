<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->string('category');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->json('stores'); // Store all store information as JSON
            $table->timestamps();
            
            // Ensure a user can't favorite the same product twice
            $table->unique(['user_id', 'product_name', 'category']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};