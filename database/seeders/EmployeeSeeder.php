<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Admin;
use Carbon\Carbon;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('vi_VN');
        
        // Lấy danh sách admin roles (cần đảm bảo đã có dữ liệu trong bảng admin)
        $adminRoles = Admin::all();
        
        if ($adminRoles->isEmpty()) {
            $this->command->info('Không có admin roles trong database. Vui lòng chạy AdminRoleSeeder trước.');
            return;
        }
        
        // Danh sách các vị trí công việc phổ biến
        $positions = [
            'Lễ tân',
            'Phục vụ',
            'Quản lý',
            'Bảo vệ',
            'Nhân viên vệ sinh',
            'Đầu bếp',
            'Kế toán',
            'Nhân viên kỹ thuật',
            'Nhân viên nhà hàng',
            'Quản lý nhân sự'
        ];
        
        // Danh sách trạng thái nhân viên - sử dụng integer thay vì string
        $statuses = [1, 0, 2]; // 1 = active, 0 = inactive, 2 = on_leave
        
        // Tạo 20 nhân viên mẫu
        for ($i = 0; $i < 10; $i++) {
            $position = $faker->randomElement($positions);
            
            // Mức lương dựa trên vị trí
            switch ($position) {
                case 'Quản lý':
                case 'Quản lý nhân sự':
                case 'Đầu bếp':
                    $salary = $faker->numberBetween(80000, 120000);
                    break;
                case 'Kế toán':
                case 'Nhân viên kỹ thuật':
                    $salary = $faker->numberBetween(60000, 90000);
                    break;
                default:
                    $salary = $faker->numberBetween(30000, 60000);
            }
            
            Employee::create([
                'full_name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->numerify('0#########'),
                'address' => $faker->address,
                'birth_day' => $faker->dateTimeBetween('-50 years', '-20 years')->format('Y-m-d'),
                'hire_date' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'position' => $position,
                'salary' => $salary,
                'admin_id' => $adminRoles->random()->id,
                'status' => $faker->randomElement($statuses),
            ]);
        }
        
        $this->command->info('Đã tạo dữ liệu nhân viên thành công!');
    }
}
