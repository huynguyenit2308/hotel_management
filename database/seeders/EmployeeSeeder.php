<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $positions = ['Receptionist', 'Housekeeping', 'Manager', 'Chef', 'Security'];
        
        for ($i = 1; $i <= 5; $i++) {
            $hireDate = Carbon::now()->subYears(rand(1, 5)); // Ngày nhận việc ngẫu nhiên trong 5 năm qua
            $salary = rand(10000000, 50000000); // Mức lương ngẫu nhiên từ 10.000.000 đến 50.000.000
            $status = rand(0, 1); // Trạng thái làm việc (1 - Đang làm, 0 - Nghỉ việc)

            $data[] = [
                'full_name' => 'Employee ' . $i,
                'email' => 'employee' . $i . '@example.com',
                'phone' => '0901234567' . $i,
                'address' => 'Address ' . $i,
                'birth_day' => Carbon::now()->subYears(rand(20, 40)),
                'hire_date' => $hireDate,
                'position' => $positions[array_rand($positions)], // Chọn vị trí ngẫu nhiên
                'salary' => $salary,
                'admin_id' => rand(1, 4), // Liên kết với admin_id từ 1 đến 5
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('employee')->insert($data);
    }
}
