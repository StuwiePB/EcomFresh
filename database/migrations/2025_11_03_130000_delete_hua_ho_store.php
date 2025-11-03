<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Deletes the CustomerStore row for "Hua Ho" and any associated
     * customer_product_prices rows. Also clears any legacy `products.store_name`
     * values referencing Hua Ho to avoid stray references.
     *
     * This is idempotent and safe to run on environments where Hua Ho no longer exists.
     */
    public function up(): void
    {
        // find the Hua Ho store id if it exists
        $store = DB::table('customer_stores')->where('name', 'Hua Ho')->first();

        if ($store) {
            // delete related prices
            DB::table('customer_product_prices')->where('store_id', $store->id)->delete();

            // delete the store row
            DB::table('customer_stores')->where('id', $store->id)->delete();
        }

        // Also clear any legacy products that may have store_name set to Hua Ho
        if (Schema::hasTable('products')) {
            DB::table('products')->where('store_name', 'Hua Ho')->update(['store_name' => null]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * Re-inserts a simple Hua Ho row if needed (no price data restored).
     */
    public function down(): void
    {
        if (! DB::table('customer_stores')->where('name', 'Hua Ho')->exists()) {
            DB::table('customer_stores')->insert([
                'name' => 'Hua Ho',
                'slug' => 'hua-ho',
                'location' => 'Bander Seri Begawan',
                'store_hours' => '7:30AM-10PM',
                'rating' => 4.4,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
};
