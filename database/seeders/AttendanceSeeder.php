<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa tất cả dữ liệu chấm công cũ - sử dụng DB::table thay vì model
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('attendance')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        $this->command->info('Đã xóa dữ liệu chấm công cũ.');
        
        // Lấy tất cả employees từ database
        $employees = Employee::all();
        
        // Nếu không có nhân viên nào, bỏ qua
        if ($employees->isEmpty()) {
            $this->command->info('Không có nhân viên nào trong database. Không thể tạo dữ liệu chấm công.');
            return;
        }
        
        // Tạo dữ liệu chấm công cho 7 ngày gần đây
        $currentDate = Carbon::now();
        $startDate = $currentDate->copy()->subDays(6); // 1 tuần (7 ngày)
        
        // Array chứa số giờ làm việc phổ biến
        $workHours = [4, 6, 8, 9, 7, 8.5];
        
        // Duyệt qua mỗi nhân viên
        foreach ($employees as $employee) {
            // Chỉ tạo chính xác 2 ngày chấm công cho mỗi nhân viên
            // Tạo mảng các ngày trong khoảng thời gian
            $allDates = [];
            $workDate = $startDate->copy();
            
            while ($workDate->lte($currentDate)) {
                if ($workDate->isWeekday()) { // Chỉ chọn các ngày làm việc (thứ 2 đến thứ 6)
                    $allDates[] = $workDate->format('Y-m-d');
                }
                $workDate->addDay();
            }
            
            // Chọn chính xác 2 ngày từ mảng (nếu có đủ ngày)
            shuffle($allDates);
            $daysToCreate = min(2, count($allDates));
            $selectedDates = array_slice($allDates, 0, $daysToCreate);
            
            // Tạo bản ghi chấm công cho những ngày đã chọn
            foreach ($selectedDates as $date) {
                Attendance::create([
                    'employee_id' => $employee->id,
                    'work_date' => $date,
                    'hours_work' => $workHours[array_rand($workHours)], // Chọn giờ làm ngẫu nhiên
                ]);
                
                $this->command->info("Tạo chấm công cho nhân viên ID: {$employee->id}, ngày: {$date}");
            }
        }
        
        $this->command->info('Đã tạo dữ liệu chấm công thành công!');
    }
}
