<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('show_email_public')->default(true);
            $table->boolean('notify_stock_low')->default(true);
            $table->boolean('notify_orders')->default(true);
            $table->boolean('two_factor_auth')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'show_email_public',
                'notify_stock_low',
                'notify_orders',
                'two_factor_auth',
            ]);
        });
    }
};
