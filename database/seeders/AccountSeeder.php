<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('account')->insert([
            [
                'customer_id' => 1,
                'username' => 'customer1',
                'password' => bcrypt('NhomA123@'),
                'admin_id' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 2,
                'username' => 'customer2',
                'password' => bcrypt('NhomA123@'),
                'admin_id' => 1,
                'status' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 3,
                'username' => 'customer3',
                'password' => bcrypt('NhomA123@'),
                'admin_id' => 1,
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
