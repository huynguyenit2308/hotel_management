<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Thêm tài khoản Super Admin
        $superAdminRole = DB::table('admin')->where('role_name', 'Super Admin')->first();
        
        // Kiểm tra xem đã có tài khoản Super Admin chưa
        $existingSuperAdmin = DB::table('customer')->where('email', 'superadmin@hotel.com')->first();
        
        if (!$existingSuperAdmin) {
            // Tạo customer cho Super Admin
            $superAdminCustomerId = DB::table('customer')->insertGetId([
                'full_name' => 'Super Admin',
                'email' => 'superadmin@hotel.com',
                'phone' => '0999888777',
                'address' => 'Hotel Management System',
                'birth_day' => '1990-01-01',
                'registration_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Tạo account cho Super Admin
            DB::table('account')->insert([
                'customer_id' => $superAdminCustomerId,
                'username' => 'superadmin',
                'password' => Hash::make('superadmin123'),
                'admin_id' => $superAdminRole->id,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Thêm tài khoản Admin
        $adminRole = DB::table('admin')->where('role_name', 'Admin')->first();
        
        // Kiểm tra xem đã có tài khoản Admin chưa
        $existingAdmin = DB::table('customer')->where('email', 'admin@hotel.com')->first();
        
        if (!$existingAdmin) {
            // Tạo customer cho Admin
            $adminCustomerId = DB::table('customer')->insertGetId([
                'full_name' => 'Admin User',
                'email' => 'admin@hotel.com',
                'phone' => '0888777666',
                'address' => 'Hotel Management',
                'birth_day' => '1992-05-15',
                'registration_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Tạo account cho Admin
            DB::table('account')->insert([
                'customer_id' => $adminCustomerId,
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'admin_id' => $adminRole->id,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Thêm tài khoản Employee
        $employeeRole = DB::table('admin')->where('role_name', 'Employee')->first();
        
        // Kiểm tra xem đã có tài khoản Employee chưa
        $existingEmployee = DB::table('employee')->where('email', 'employee@hotel.com')->first();
        
        if (!$existingEmployee) {
            // Tạo employee đầu tiên
            $employeeId = DB::table('employee')->insertGetId([
                'full_name' => 'Employee User',
                'email' => 'employee@hotel.com',
                'phone' => '0777666555',
                'address' => 'Hotel Staff Office',
                'birth_day' => '1995-08-20',
                'hire_date' => now(),
                'position' => 'Receptionist',
                'salary' => 10000000,
                'admin_id' => $employeeRole->id,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Lấy quyền Customer
        $customerRole = DB::table('admin')->where('role_name', 'Customer')->first();
        
        // Thêm các tài khoản thông thường
        $regularCustomers = [
            [
                'full_name' => 'Nguyễn Văn A',
                'email' => 'nguyenvana@example.com',
                'phone' => '0912345678',
                'address' => 'Quận 1, TP. Hồ Chí Minh',
                'birth_day' => '1990-03-15',
                'username' => 'nguyenvana',
                'password' => 'password123'
            ],
            [
                'full_name' => 'Trần Thị B',
                'email' => 'tranthib@example.com',
                'phone' => '0923456789',
                'address' => 'Quận 2, TP. Hồ Chí Minh',
                'birth_day' => '1992-07-22',
                'username' => 'tranthib',
                'password' => 'password123'
            ],
            [
                'full_name' => 'Lê Minh C',
                'email' => 'leminhc@example.com',
                'phone' => '0934567890',
                'address' => 'Quận 9, TP. Hồ Chí Minh',
                'birth_day' => '1988-12-05',
                'username' => 'leminhc',
                'password' => 'password123'
            ],
            [
                'full_name' => 'Phạm Thị D',
                'email' => 'phamthid@example.com',
                'phone' => '0945678901',
                'address' => 'Quận Gò Vấp, TP. Hồ Chí Minh',
                'birth_day' => '1995-05-30',
                'username' => 'phamthid',
                'password' => 'password123'
            ],
            [
                'full_name' => 'Hoàng Văn E',
                'email' => 'hoangvane@example.com',
                'phone' => '0956789012',
                'address' => 'Quận Bình Thạnh, TP. Hồ Chí Minh',
                'birth_day' => '1985-09-18',
                'username' => 'hoangvane',
                'password' => 'password123'
            ],
        ];
        
        foreach ($regularCustomers as $customer) {
            // Kiểm tra xem email đã tồn tại chưa
            $existingCustomer = DB::table('customer')->where('email', $customer['email'])->first();
            
            if (!$existingCustomer) {
                // Tạo customer 
                $customerId = DB::table('customer')->insertGetId([
                    'full_name' => $customer['full_name'],
                    'email' => $customer['email'],
                    'phone' => $customer['phone'],
                    'address' => $customer['address'],
                    'birth_day' => $customer['birth_day'],
                    'registration_date' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Kiểm tra xem username đã tồn tại chưa
                $existingUsername = DB::table('account')->where('username', $customer['username'])->first();
                
                if (!$existingUsername) {
                    // Tạo account cho customer
                    DB::table('account')->insert([
                        'customer_id' => $customerId,
                        'username' => $customer['username'],
                        'password' => Hash::make($customer['password']),
                        'admin_id' => $customerRole ? $customerRole->id : null,
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
} 