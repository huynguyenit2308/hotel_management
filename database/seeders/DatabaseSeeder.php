<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Attendance;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            CustomerSeeder::class,
            AdminSeeder::class,
            AccountSeeder::class,
            RoomStatusSeeder::class,
            RoomSeeder::class,
            BookingSeeder::class,
            ServiceSeeder::class,
            InvoiceSeeder::class,
            EmployeeSeeder::class,
            AttendanceSeeder::class,
            WageSeeder::class,
            BookingServiceSeeder::class,
            RatingSeeder::class,
            VoucherSeeder::class,
            InvoiceServiceSeeder::class,
        ]);
    }
}
