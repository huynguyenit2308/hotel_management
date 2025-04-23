<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomStatus;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            [
                'room_number' => '101',
                'room_type' => 'Standard',
                'price' => 500000,
                'status_id' => 1
            ],
            [
                'room_number' => '102',
                'room_type' => 'Deluxe',
                'price' => 800000,
                'status_id' => 1
            ],
            [
                'room_number' => '201',
                'room_type' => 'Suite',
                'price' => 1200000,
                'status_id' => 1
            ],
            [
                'room_number' => '202',
                'room_type' => 'Standard',
                'price' => 500000,
                'status_id' => 2
            ],
            [
                'room_number' => '301',
                'room_type' => 'Deluxe',
                'price' => 800000,
                'status_id' => 1
            ],
            [
                'room_number' => '302',
                'room_type' => 'Suite',
                'price' => 1200000,
                'status_id' => 3
            ],
            [
                'room_number' => '401',
                'room_type' => 'Standard',
                'price' => 500000,
                'status_id' => 1
            ],
            [
                'room_number' => '402',
                'room_type' => 'Deluxe',
                'price' => 800000,
                'status_id' => 4
            ],
            [
                'room_number' => '501',
                'room_type' => 'Suite',
                'price' => 1200000,
                'status_id' => 1
            ],
            [
                'room_number' => '502',
                'room_type' => 'Standard',
                'price' => 500000,
                'status_id' => 1
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
} 