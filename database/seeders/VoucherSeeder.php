<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VoucherSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 20; $i++) {
            $type = rand(0, 1) ? 'percent' : 'fixed';
            $value = $type === 'percent' ? rand(10, 50) : rand(100000, 1000000);

            $startDate = Carbon::now()->subDays(rand(1, 30));
            $endDate = Carbon::now()->addDays(rand(1, 30));

            $data[] = [
                'code' => 'VOUCHER' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'type' => $type,
                'value' => $value,
                'usage_limit' => rand(1, 100),
                'used_count' => rand(0, 50),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'active' => rand(0, 1) ? true : false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('voucher')->insert($data);
    }
}
