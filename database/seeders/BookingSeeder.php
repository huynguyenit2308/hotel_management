<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // $bookings = [
        //     [
        //         'customer_id' => 1,
        //         'room_id' => 1,
        //         'booking_date' => Carbon::now(),
        //         'check_in_date' => Carbon::now()->addDays(1),
        //         'check_out_date' => Carbon::now()->addDays(3),
        //         'status_name' => 'Confirmed',
        //     ],
        //     [
        //         'customer_id' => 2,
        //         'room_id' => 2,
        //         'booking_date' => Carbon::now(),
        //         'check_in_date' => Carbon::now()->addDays(2),
        //         'check_out_date' => Carbon::now()->addDays(4),
        //         'status_name' => 'Pending',
        //     ],
        //     [
        //         'customer_id' => 3,
        //         'room_id' => 3,
        //         'booking_date' => Carbon::now(),
        //         'check_in_date' => Carbon::now()->addDays(5),
        //         'check_out_date' => Carbon::now()->addDays(7),
        //         'status_name' => 'Confirmed',
        //     ],
        // ];

        // foreach ($bookings as $booking) {
        //     Booking::create($booking);
        // }
    }
}