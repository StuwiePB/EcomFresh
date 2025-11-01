<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('customer_products');
            $table->foreignId('store_id')->constrained('customer_stores');
            $table->decimal('current_price', 8, 2); // 3.60, 4.10, etc.
            $table->decimal('original_price', 8, 2)->nullable(); // For discounts
            $table->boolean('in_stock')->default(true);
            $table->boolean('is_discounted')->default(false);
            $table->timestamp('price_updated_at')->useCurrent();
            $table->timestamps();
            
            // A product can only have one price per store
            $table->unique(['product_id', 'store_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_product_prices');
    }
};