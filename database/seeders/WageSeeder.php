<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WageSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 20; $i++) {
            // Lấy tổng số giờ làm việc của nhân viên từ bảng attendance
            $totalHours = DB::table('attendance')->where('employee_id', rand(1, 5))
                ->sum('hours_work'); // Tổng giờ làm việc của nhân viên

            // Tính lương tổng (ví dụ: 1 giờ làm việc = 100.000 đồng)
            $totalWage = $totalHours * 100000;

            $data[] = [
                'employee_id' => rand(1, 5), // ID nhân viên từ 1 đến 5 (phụ thuộc vào bảng `employee`)
                'total_hours' => $totalHours,
                'total_wage' => $totalWage,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('wage')->insert($data);
    }
}
