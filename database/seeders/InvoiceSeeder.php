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
        $methods = ['cash', 'online'];

        for ($i = 1; $i <= 20; $i++) {
            $status = $statuses[array_rand($statuses)];

            $paymentMethod = 'none';
            if ($status === 'Paid') {
                $paymentMethod = $methods[array_rand($methods)];
            }

            $data[] = [
                'customer_id' => rand(1, 5),
                'create_at' => Carbon::now()->subDays(rand(1, 30)),
                'total_amount' => rand(500000, 10000000),
                'payment_method' => $paymentMethod,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('invoice')->insert($data);
    }
}
