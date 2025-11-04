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
        if (! Schema::hasTable('users')) {
            return;
        }

        // Add `role` column if missing
        if (! Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user')->after('password');
            });
        }

        // Add `store_name` column if missing
        if (! Schema::hasColumn('users', 'store_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('store_name')->nullable()->after('role');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        if (Schema::hasColumn('users', 'store_name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('store_name');
            });
        }

        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
