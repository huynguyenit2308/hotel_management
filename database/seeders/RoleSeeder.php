<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin')->insert([
            [
                'id' => 1,
                'role_name' => 'admin',
                'description' => 'Quản trị hệ thống',
            ],
            [
                'id' => 2,
                'role_name' => 'user',
                'description' => 'Người dùng thường',
            ],          
        ]);
    }
}
