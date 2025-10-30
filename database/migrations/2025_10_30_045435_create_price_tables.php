<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Stores table
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable();
            $table->timestamps();
        });

        // Products table
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category');
            $table->foreignId('store_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Price history table
        Schema::create('price_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('current_price', 8, 2);
            $table->decimal('last_month_price', 8, 2);
            $table->decimal('two_months_ago_price', 8, 2);
            $table->decimal('three_months_ago_price', 8, 2);
            $table->date('recorded_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('price_history');
        Schema::dropIfExists('products');
        Schema::dropIfExists('stores');
    }
};