<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'role_name' => 'Super Admin',
                'description' => 'Có tất cả các quyền trong hệ thống',
                'permissions' => json_encode([
                    'user_view', 'user_create', 'user_edit', 'user_delete',
                    'customer_view', 'customer_create', 'customer_edit', 'customer_delete',
                    'employee_view', 'employee_create', 'employee_edit', 'employee_delete',
                    'room_view', 'room_create', 'room_edit', 'room_delete',
                    'service_view', 'service_create', 'service_edit', 'service_delete',
                    'booking_view', 'booking_create', 'booking_edit', 'booking_delete',
                    'invoice_view', 'invoice_create', 'invoice_edit', 'invoice_delete',
                    'role_view', 'role_create', 'role_edit', 'role_delete',
                ]),
                'is_default' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Admin',
                'description' => 'Quản lý hệ thống',
                'permissions' => json_encode([
                    'user_view', 'user_create', 'user_edit',
                    'customer_view', 'customer_create', 'customer_edit',
                    'employee_view', 'employee_create', 'employee_edit',
                    'room_view', 'room_create', 'room_edit',
                    'service_view', 'service_create', 'service_edit',
                    'booking_view', 'booking_create', 'booking_edit',
                    'invoice_view', 'invoice_create', 'invoice_edit',
                ]),
                'is_default' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Employee',
                'description' => 'Nhân viên khách sạn',
                'permissions' => json_encode([
                    'customer_view', 'customer_create', 'customer_edit',
                    'room_view',
                    'service_view',
                    'booking_view', 'booking_create', 'booking_edit',
                    'invoice_view', 'invoice_create',
                ]),
                'is_default' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Customer',
                'description' => 'Khách hàng thông thường',
                'permissions' => json_encode([
                    'room_view',
                    'service_view',
                    'booking_view', 'booking_create',
                ]),
                'is_default' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($roles as $role) {
            // Kiểm tra xem vai trò đã tồn tại hay chưa
            $exists = DB::table('admin')->where('role_name', $role['role_name'])->exists();
            
            if (!$exists) {
                DB::table('admin')->insert($role);
            } else {
                // Cập nhật vai trò nếu đã tồn tại
                DB::table('admin')
                    ->where('role_name', $role['role_name'])
                    ->update([
                        'description' => $role['description'],
                        'permissions' => $role['permissions'],
                        'is_default' => $role['is_default'],
                        'updated_at' => now()
                    ]);
            }
        }
    }
} 