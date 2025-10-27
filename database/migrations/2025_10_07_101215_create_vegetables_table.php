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
        Schema::create('vegetables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->text('description')->nullable(); // 🆕 Optional description
            $table->string('image')->nullable(); // 🆕 For image uploads
            $table->string('status')->default('active'); // 🆕 Track active/inactive
            $table->softDeletes(); // enables soft delete
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vegetables');
    }
};
