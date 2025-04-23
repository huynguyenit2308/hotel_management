<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomStatus;

class RoomStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['status_name' => 'Available'],
            ['status_name' => 'Occupied'],
            ['status_name' => 'Maintenance'],
            ['status_name' => 'Reserved'],
        ];

        foreach ($statuses as $status) {
            RoomStatus::create($status);
        }
    }
} 