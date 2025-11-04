<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PriceHistorySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Create stores
        $soonLeeId = DB::table('stores')->insertGetId([
            'name' => 'Soon Lee',
            'location' => 'Sengkurong, Brunei',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $supaId = DB::table('stores')->insertGetId([
            'name' => 'SupaSave',
            'location' => 'Gadong, Brunei',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Insert products for both stores
        $products = [
            // Soon Lee Products
            ['name' => 'Chicken Breast', 'description' => 'Fresh • Premium Cut', 'category' => 'chicken', 'store_id' => $soonLeeId],
            ['name' => 'Whole Chicken', 'description' => 'Fresh • Farm Raised', 'category' => 'chicken', 'store_id' => $soonLeeId],
            ['name' => 'Ribeye Steak', 'description' => 'Premium Cut • Marbled', 'category' => 'beef', 'store_id' => $soonLeeId],
            ['name' => 'Strip Loin Steak', 'description' => 'Premium Cut • Lean', 'category' => 'beef', 'store_id' => $soonLeeId],
            ['name' => 'Fresh Carrots', 'description' => 'Local • Per 500g', 'category' => 'vegetables', 'store_id' => $soonLeeId],
            ['name' => 'Fresh Cabbage', 'description' => 'Local • Per Head', 'category' => 'vegetables', 'store_id' => $soonLeeId],
            
            // SupaSave Products
            ['name' => 'Chicken Breast', 'description' => 'Fresh • Premium Cut', 'category' => 'chicken', 'store_id' => $supaId],
            ['name' => 'Whole Chicken', 'description' => 'Fresh • Farm Raised', 'category' => 'chicken', 'store_id' => $supaId],
            ['name' => 'Ribeye Steak', 'description' => 'Premium Cut • Marbled', 'category' => 'beef', 'store_id' => $supaId],
            ['name' => 'Strip Loin Steak', 'description' => 'Premium Cut • Lean', 'category' => 'beef', 'store_id' => $supaId],
            ['name' => 'Fresh Carrots', 'description' => 'Local • Per 500g', 'category' => 'vegetables', 'store_id' => $supaId],
            ['name' => 'Fresh Cabbage', 'description' => 'Local • Per Head', 'category' => 'vegetables', 'store_id' => $supaId],
        ];

        foreach ($products as $p) {
            DB::table('products')->insert(array_merge($p, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        // Get product IDs and insert price histories
        $products = DB::table('products')->get();
        foreach ($products as $p) {
            // Example price history - adjust prices as needed
            DB::table('price_history')->insert([
                'product_id' => $p->id,
                'current_price' => $p->store_id == $soonLeeId ? 3.65 : 3.40,
                'last_month_price' => $p->store_id == $soonLeeId ? 3.55 : 3.45,
                'two_months_ago_price' => $p->store_id == $soonLeeId ? 3.60 : 3.50,
                'three_months_ago_price' => $p->store_id == $soonLeeId ? 3.50 : 3.60,
                'recorded_date' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}