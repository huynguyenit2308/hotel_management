<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('voucher')->insert([
            [
                'code' => 'WELCOME10',
                'type' => 'percent',
                'value' => 10,
                'usage_limit' => 100,
                'used_count' => 0,
                'start_date' => now()->subDays(1),
                'end_date' => now()->addDays(30),
                'active' => true,
            ],
            [
                'code' => 'FREESHIP50K',
                'type' => 'fixed',
                'value' => 50000,
                'usage_limit' => 50,
                'used_count' => 10,
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(15),
                'active' => true,
            ],
            [
                'code' => 'SUMMER20',
                'type' => 'percent',
                'value' => 20,
                'usage_limit' => 200,
                'used_count' => 150,
                'start_date' => now(),
                'end_date' => now()->addDays(60),
                'active' => true,
            ],
        ]);
    }
}
