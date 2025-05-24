<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingServiceSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 20; $i++) {
            $bookingDate = Carbon::now()->subDays(rand(1, 30));
            $status = ['pending', 'confirmed', 'cancelled'][rand(0, 2)];

            $data[] = [
                'customer_id' => rand(1, 5),
                'service_id' => rand(1, 10),
                'booking_date' => $bookingDate,
                'note' => 'Ghi chú dịch vụ ' . $i,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('booking_service')->insert($data);
    }
}
