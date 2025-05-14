<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $statuses = ['Paid', 'Pending', 'Cancelled'];

        for ($i = 1; $i <= 20; $i++) {
            $data[] = [
                'customer_id' => rand(1, 5),
                'create_at' => Carbon::now()->subDays(rand(1, 30)),
                'total_amount' => rand(500000, 10000000),
                'status' => $statuses[array_rand($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('invoice')->insert($data);
    }
}
