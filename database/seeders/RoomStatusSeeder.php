<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomStatusSeeder extends Seeder
{
    public function run()
    {
        DB::table('room_status')->insert([
            [
                'status_name' => 'Available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_name' => 'Booked',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_name' => 'Maintenance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
