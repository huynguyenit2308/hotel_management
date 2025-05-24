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
                'image' => 'service_images/massage.png',
                'description' => 'Massage thư giãn cho cơ thể.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Spa',
                'price' => 500000,
                'image' => 'service_images/spa.jpg',
                'description' => 'Dịch vụ Spa thư giãn, chăm sóc sức khoẻ.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Bữa sáng',
                'price' => 150000,
                'image' => 'service_images/anuong.jpg',
                'description' => 'Bữa sáng kiểu buffet hoặc set menu.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Đưa đón sân bay',
                'price' => 700000,
                'image' => 'service_images/duadon.jfif',
                'description' => 'Dịch vụ xe đưa đón sân bay thuận tiện.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Phòng gym',
                'price' => 200000,
                'image' => 'service_images/tapgym.jpg',
                'description' => 'Sử dụng phòng gym của khách sạn.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Dịch vụ 1',
                'price' => 200000,
                'image' => 'service_images/tapgym.jpg',
                'description' => 'Sử dụng dịch vụ 1 của khách sạn.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Dịch vụ 2',
                'price' => 200000,
                'image' => 'service_images/tapgym.jpg',
                'description' => 'Sử dụng dịch vụ 2 của khách sạn.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Dịch vụ 3',
                'price' => 200000,
                'image' => 'service_images/tapgym.jpg',
                'description' => 'Sử dụng dịch vụ 3 của khách sạn.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Dịch vụ 4',
                'price' => 200000,
                'image' => 'service_images/tapgym.jpg',
                'description' => 'Sử dụng dịch vụ 4 của khách sạn.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Dịch vụ 5',
                'price' => 200000,
                'image' => 'service_images/tapgym.jpg',
                'description' => 'Sử dụng dịch vụ 5 của khách sạn.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
