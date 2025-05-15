<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('admin')->insert([
            [
                'role_name' => 'Super Admin',
                'description' => 'Toàn quyền hệ thống',
                'permissions' => json_encode(['manage_users', 'manage_roles', 'view_reports', 'full_access']),
                'is_default' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Manager',
                'description' => 'Quản lý hoạt động chung',
                'permissions' => json_encode(['view_reports', 'manage_staff', 'manage_bookings']),
                'is_default' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Receptionist',
                'description' => 'Tiếp nhận và xử lý đặt phòng',
                'permissions' => json_encode(['create_booking', 'check_in', 'check_out']),
                'is_default' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Accountant',
                'description' => 'Quản lý thanh toán và hoá đơn',
                'permissions' => json_encode(['view_payments', 'generate_invoice']),
                'is_default' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
