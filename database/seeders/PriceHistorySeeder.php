<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PriceHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Create stores
        $supaId = DB::table('stores')->insertGetId([
            'name' => 'SupaSave',
            'location' => 'Gadong, Brunei',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $soonId = DB::table('stores')->insertGetId([
            'name' => 'Soon Lee',
            'location' => 'Sengkurong, Brunei',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Create products
        $chickenSupaId = DB::table('products')->insertGetId([
            'name' => 'Chicken Breast',
            'description' => 'Fresh • Budget Friendly',
            'category' => 'chicken',
            'store_id' => $supaId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $ribeyeSupaId = DB::table('products')->insertGetId([
            'name' => 'Ribeye Steak',
            'description' => 'Premium Quality • Fresh',
            'category' => 'beef',
            'store_id' => $supaId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $ribeyeSoonId = DB::table('products')->insertGetId([
            'name' => 'Ribeye Steak',
            'description' => 'Premium Quality • Fresh',
            'category' => 'beef',
            'store_id' => $soonId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Insert price history rows (each row contains 4-month snapshot)
        DB::table('price_history')->insert([
            [
                'product_id' => $chickenSupaId,
                'current_price' => 3.40,
                'last_month_price' => 3.45,
                'two_months_ago_price' => 3.50,
                'three_months_ago_price' => 3.60,
                'recorded_date' => $now->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => $ribeyeSupaId,
                'current_price' => 17.95,
                'last_month_price' => 18.75,
                'two_months_ago_price' => 18.50,
                'three_months_ago_price' => 18.00,
                'recorded_date' => $now->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'product_id' => $ribeyeSoonId,
                'current_price' => 16.90,
                'last_month_price' => 17.90,
                'two_months_ago_price' => 17.50,
                'three_months_ago_price' => 17.20,
                'recorded_date' => $now->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
