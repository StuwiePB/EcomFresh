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
        $users = [
            [
                'name' => 'SoonLee Admin',
                'email' => 'soonlee@ecomfresh.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'store_name' => 'SoonLee',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'SupaSave Admin',
                'email' => 'supasave@ecomfresh.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'store_name' => 'SupaSave',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('users')->insert($users);

        $this->command->info('Successfully created SoonLee and SupaSave admin users!');
        $this->command->info('SoonLee Login: soonlee@ecomfresh.com / password123');
        $this->command->info('SupaSave Login: supasave@ecomfresh.com / password123');
    }
}