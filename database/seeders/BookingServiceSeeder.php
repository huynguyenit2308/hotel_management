<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('booking_service')->insert([
            [
                'customer_id' => 1,
                'service_id' => 1,
                'booking_date' => now()->addDays(1),
                'note' => 'Lần đầu đặt dịch vụ này.',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 2,
                'service_id' => 2,
                'booking_date' => now()->addDays(2),
                'note' => 'Khách hàng yêu cầu thêm dịch vụ VIP.',
                'status' => 'confirmed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'customer_id' => 3,
                'service_id' => 3,
                'booking_date' => now()->addDays(3),
                'note' => 'Dịch vụ này có thể thay đổi giờ.',
                'status' => 'cancelled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
