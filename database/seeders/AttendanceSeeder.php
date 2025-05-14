<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 20; $i++) {
            $workDate = Carbon::now()->subDays(rand(1, 30)); // Ngày làm việc trong vòng 30 ngày qua
            $hoursWorked = rand(4, 12); // Số giờ làm việc ngẫu nhiên từ 4 đến 12 giờ

            $data[] = [
                'employee_id' => rand(1, 5), // ID nhân viên từ 1 đến 5 (phụ thuộc vào bảng `employee`)
                'work_date' => $workDate,
                'hours_work' => $hoursWorked,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('attendance')->insert($data);
    }
}
