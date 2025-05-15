<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $roomTypes = ['Standard', 'Deluxe', 'Suite', 'Family'];
        $statuses = ['Available', 'Booked', 'Maintenance'];

        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'room_number' => str_pad($i, 3, '0', STR_PAD_LEFT),
                'room_type' => $roomTypes[array_rand($roomTypes)],
                'price' => rand(500000, 2000000),
                'image' => 'path_to_image',
                'status_id' => rand(1, 3),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('room')->insert($data);
    }
}
