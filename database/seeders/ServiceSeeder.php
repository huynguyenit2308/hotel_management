<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        DB::table('service')->insert([
            [
                'service_name' => 'Massage',
                'price' => 300000,
                'image' => 'path_to_image',
                'description' => 'Massage thư giãn cho cơ thể.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Spa',
                'price' => 500000,
                'image' => 'path_to_image',
                'description' => 'Dịch vụ Spa thư giãn, chăm sóc sức khoẻ.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Bữa sáng',
                'price' => 150000,
                'image' => 'path_to_image',
                'description' => 'Bữa sáng kiểu buffet hoặc set menu.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Đưa đón sân bay',
                'price' => 700000,
                'image' => 'path_to_image',
                'description' => 'Dịch vụ xe đưa đón sân bay thuận tiện.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Phòng gym',
                'price' => 200000,
                'image' => 'path_to_image',
                'description' => 'Sử dụng phòng gym của khách sạn.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
