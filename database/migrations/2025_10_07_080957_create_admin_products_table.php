<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    if (!Schema::hasTable('admin_products')) {
    Schema::create('admin_products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('category')->nullable();
        $table->decimal('price', 8, 2)->default(0);
        $table->integer('stock')->default(0);
        $table->softDeletes();
        $table->timestamps();
    });
}
}
};
