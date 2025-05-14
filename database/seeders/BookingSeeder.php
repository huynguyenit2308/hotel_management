<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $statuses = ['Pending', 'Checked In', 'Completed'];
        
        for ($i = 1; $i <= 20; $i++) {
            $checkInDate = Carbon::now()->addDays(rand(1, 15));
            $checkOutDate = $checkInDate->copy()->addDays(rand(1, 7));

            $data[] = [
                'customer_id' => rand(1, 5),
                'room_id' => rand(1, 10),
                'booking_date' => Carbon::now()->subDays(rand(1, 30)),
                'check_in_date' => $checkInDate,
                'check_out_date' => $checkOutDate,
                'status_name' => $statuses[array_rand($statuses)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('booking')->insert($data);
    }
}
