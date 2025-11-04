<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class StoreAdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name' => 'Soon Lee Admin',
            'email' => 'soonlee@ecomfresh.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'store_name' => 'Soon Lee',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        // Insert single Soon Lee admin user (idempotency not handled here; runers can wipe or handle duplicates)
        DB::table('users')->insert($user);

        $this->command->info('Successfully created Soon Lee admin user!');
        $this->command->info('Soon Lee Login: soonlee@ecomfresh.com / password123');
    }
}