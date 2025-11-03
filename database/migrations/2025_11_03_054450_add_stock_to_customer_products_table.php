<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('customer_products', function (Blueprint $table) {
            $table->integer('stock')->default(0)->after('description');
            $table->string('status')->default('active')->after('stock');
        });
        
        // Also add store-specific stock if needed
        Schema::table('customer_product_prices', function (Blueprint $table) {
            $table->integer('stock')->default(0)->after('in_stock');
        });
    }

    public function down()
    {
        Schema::table('customer_products', function (Blueprint $table) {
            $table->dropColumn(['stock', 'status']);
        });
        
        Schema::table('customer_product_prices', function (Blueprint $table) {
            $table->dropColumn('stock');
        });
    }
};