<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 5; $i++) {
            $data[] = [
                'customer_id' => $i,
                'username' => 'user' . $i,
                'password' => Hash::make('password' . $i . '$'),
                'admin_id' => rand(1, 4),
                'status' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('account')->insert($data);
    }
}