<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beefs', function (Blueprint $table) {
            // Add image column first if it doesn't exist
            if (!Schema::hasColumn('beefs', 'image')) {
                $table->string('image')->nullable()->after('stock');
            }

            // Add status column (no "after" to avoid missing-column errors)
            if (!Schema::hasColumn('beefs', 'status')) {
                $table->string('status')->default('active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('beefs', function (Blueprint $table) {
            if (Schema::hasColumn('beefs', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('beefs', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
