<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Only add the column if it doesn't already exist (prevents duplicate column errors)
        if (!Schema::hasColumn('products', 'store_name')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('store_name')->nullable()->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'store_name')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('store_name');
            });
        }
    }
};
